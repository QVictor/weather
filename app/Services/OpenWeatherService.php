<?php

namespace App\Services;

use App\Helpers\CityHelper;
use App\Models\OpenWeatherData;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

class OpenWeatherService
{
    protected $api_key;

    public function __construct()
    {
        $this->api_key = env('OPEN_WEATHER_API_KEY');
    }

    public function receiveAndSaveData()
    {
        $cities = CityHelper::getAllCodes();
        $currentWeather = $this->getCurrentWeatherData($cities);
    }

    public function getCurrentWeatherData(string $cities)
    {
        try {
            $answer = Http::get(env('OPEN_WEATHER_URL_WITH_VERSION') . '/group?id=' . $cities . '&units=metric&appid=' . env('OPEN_WEATHER_API_KEY'));
            return self::httpAnswerToArray($answer);
        } catch (Exception $exception) {
            Log::error($exception);
        }
    }

    public static function httpAnswerToArray(Response $answer): array
    {
        $jsonString = $answer->getBody()->getContents();
        return json_decode($jsonString, true);
    }

    private function prepareDataFromInsert($apiAnswer): array
    {
        $res = [];
        foreach ($apiAnswer['list'] as $city) {
            $res[] = [
                'city_id' => $city['id'],
                'weather_condition_code' => $city['weather'][0]['id'],
                'weather_condition_main_type' => $city['weather'][0]['main'],
                'weather_condition_description' => $city['weather'][0]['description'],
                'weather_condition_icon' => $city['weather'][0]['icon'],
                'temp' => $city['main']['temp'],
                'humidity' => $city['main']['humidity'],
                'wind_speed' => $city['wind']['speed'],
                'created_at' => Carbon::createFromTimestamp($city['dt']),
                'updated_at' => Carbon::createFromTimestamp($city['dt']),
            ];
        }
        return $res;
    }
}
