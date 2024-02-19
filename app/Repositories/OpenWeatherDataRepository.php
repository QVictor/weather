<?php

namespace App\Repositories;

use App\Models\OpenWeatherData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class OpenWeatherDataRepository extends BaseRepository
{
    protected function getModelClass(): string
    {
        return OpenWeatherData::class;
    }

    public function getStatistic($cityId): Collection
    {
        return $this->model
            ->where('city_id', $cityId)
            ->get();
    }

    public function getAverageStatistic($cityId, $groupBy): Collection
    {
         $query = $this->model
            ->with('city')
            ->where('city_id', $cityId)
            ->select(
                'city_id',
                DB::raw('ROUND(AVG(temp), 1) as avg_temp'),
                DB::raw('ROUND(AVG(wind_speed), 1) as avg_wind_speed'),
                DB::raw('ROUND(AVG(humidity), 0) as avg_humidity'),
            );
        switch ($groupBy) {
            case OpenWeatherData::STATISTIC_GROUP_BY_DAILY:
                $query = $query->addSelect(DB::raw('DATE(created_at) as date'));
                break;
            case OpenWeatherData::STATISTIC_GROUP_BY_MONTHLY:
                $query = $query->addSelect(DB::raw('MONTHNAME(created_at) as date'));
                break;
            case OpenWeatherData::STATISTIC_GROUP_BY_YEARLY:
                $query = $query->addSelect(DB::raw('YEAR(created_at) as date'));
                break;
            default : {
                $query = $query->addSelect(DB::raw('DATE(created_at) as date'));
            }
        }
         return $query->groupBy('date')
            ->get();
    }
}
