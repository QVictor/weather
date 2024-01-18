<?php

namespace App\Services\Statistics;

use App\Repositories\OpenWeatherDataRepository;

class GetStatisticsService
{
    public function get($cityId)
    {
        return (new OpenWeatherDataRepository())->getStatistic($cityId);
    }
}
