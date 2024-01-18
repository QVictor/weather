<?php

namespace App\Repositories;

use App\Models\OpenWeatherData;
use Illuminate\Database\Eloquent\Collection;

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
}
