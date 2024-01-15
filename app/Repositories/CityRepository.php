<?php

namespace App\Repositories;

use App\Models\City;
use App\Repositories\Interfaces\CityRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CityRepository extends BaseRepository
{
    protected function getModelClass(): string
    {
        return City::class;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function getAllListCodes(): Collection
    {
        return $this->model->all('open_weather_city_id');
    }
}
