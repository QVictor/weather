<?php

namespace App\Services\Statistics;

use App\Repositories\AirPollutionRepository;
use App\Repositories\OpenWeatherDataRepository;

class GetAirPollutionStatisticsService
{
    public function get($cityId, $groupBy)
    {
        return (new AirPollutionRepository())->getAverage($cityId, $groupBy);
    }
}
