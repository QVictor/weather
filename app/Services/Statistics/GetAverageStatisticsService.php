<?php

namespace App\Services\Statistics;

use App\Repositories\OpenWeatherDataRepository;

class GetAverageStatisticsService
{
    public function get($cityId, $groupBy)
    {
        return (new OpenWeatherDataRepository())->getAverageStatistic($cityId, $groupBy);
    }
}
