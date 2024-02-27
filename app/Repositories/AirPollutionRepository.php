<?php

namespace App\Repositories;

use App\Models\AirPollution;
use App\Models\OpenWeatherData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AirPollutionRepository extends BaseRepository
{
    protected function getModelClass(): string
    {
        return AirPollution::class;
    }

    public function getAverage($cityId, $groupBy): Collection
    {
         $query = $this->model
            ->with('city')
            ->where('city_id', $cityId)
            ->select(
                'city_id',
                DB::raw('ROUND(AVG(air_quality_index), 2) as avg_air_quality_index'),
                DB::raw('ROUND(AVG(co), 2) as avg_co'),
                DB::raw('ROUND(AVG(so2), 2) as avg_so2'),
                DB::raw('ROUND(AVG(no2), 2) as avg_no2'),
                DB::raw('ROUND(AVG(o3), 2) as avg_o3'),
                DB::raw('ROUND(AVG(pm10), 2) as avg_pm10'),
                DB::raw('ROUND(AVG(pm2_5), 2) as avg_pm2_5'),
            );
        switch ($groupBy) {
            case OpenWeatherData::STATISTIC_GROUP_BY_DAILY:
                $query = $query->addSelect(DB::raw('DATE(datetime) as date'));
                break;
            case OpenWeatherData::STATISTIC_GROUP_BY_MONTHLY:
                $query = $query->addSelect(DB::raw('MONTHNAME(datetime) as date'));
                break;
            case OpenWeatherData::STATISTIC_GROUP_BY_YEARLY:
                $query = $query->addSelect(DB::raw('YEAR(datetime) as date'));
                break;
            default : {
                $query = $query->addSelect(DB::raw('DATE(datetime) as date'));
            }
        }
         return $query->groupBy('date')
            ->get();
    }
}
