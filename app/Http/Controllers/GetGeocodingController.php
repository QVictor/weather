<?php

namespace App\Http\Controllers;

use App\Helpers\CityHelper;
use App\Http\Resources\CitiesResource;
use App\Models\City;
use App\Services\CitiesService;
use App\Services\OpenWeatherService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;

class GetGeocodingController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __invoke()
    {
        return (new OpenWeatherService())->receiveAndSaveAirPollutionData();
    }
}
