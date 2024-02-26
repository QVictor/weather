<?php

namespace App\Services;

use App\Helpers\CityHelper;
use App\Models\AirPollution;
use App\Models\City;
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
        OpenWeatherData::insert($this->prepareDataFromInsert($currentWeather));
    }

    public function receiveAndSaveAirPollutionData()
    {
        $cities = City::all();
        $needleInsert = [];
        foreach ($cities as $city) {
            $airPollution = $this->airPollutionApi($city->latitude, $city->longitude);
            $needleInsert[] = $this->prepareDataFromInsertAirPollution($city->open_weather_city_id, $airPollution);
        }
        AirPollution::insert($needleInsert);
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

    public function geocodingApi(string $city, string $country)
    {
        try {
            $answer = Http::get('http://api.openweathermap.org/geo/1.0/direct?q='.$city.','.$country.'&limit=5&appid=' . env('OPEN_WEATHER_API_KEY'));
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

    public function airPollutionApi($latitude, $longitude)
    {
        try {
            $answer = Http::get('http://api.openweathermap.org/data/2.5/air_pollution?lat='.$latitude.'1&lon='.$longitude.'&appid=' . env('OPEN_WEATHER_API_KEY'));
            return self::httpAnswerToArray($answer);
        } catch (Exception $exception) {
            Log::error($exception);
        }
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

    private function prepareDataFromInsertAirPollution($cityId, $apiAnswer): array
    {
        $components = $apiAnswer['list'][0]['components'];
        $now = Carbon::now();
        return [
            'city_id' => $cityId,
            'air_quality_index' => $apiAnswer['list'][0]['main']['aqi'],
            'co' => $components['co'],
            'no' => $components['no'],
            'no2' => $components['no2'],
            'o3' => $components['o3'],
            'so2' => $components['so2'],
            'pm2_5' => $components['pm2_5'],
            'pm10' => $components['pm10'],
            'nh3' => $components['nh3'],
            'datetime' => Carbon::parse($apiAnswer['list'][0]['dt']),
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }
}
