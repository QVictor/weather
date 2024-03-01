<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Requests\GetAirPollutionRequest;
use App\Http\Requests\GetStatisticsRequest;
use App\Http\Resources\Statistics\GetAirPollutionResource;
use App\Models\City;
use App\Services\OpenWeatherService;
use App\Services\Statistics\GetAirPollutionStatisticsService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class GetAirPollutionStatisticsController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __invoke(GetAirPollutionRequest $getStatisticsRequest)
    {
        return GetAirPollutionResource::collection((new GetAirPollutionStatisticsService())->get($getStatisticsRequest->city_id, $getStatisticsRequest->group_by));
    }
}
