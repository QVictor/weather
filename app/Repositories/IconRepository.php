<?php

namespace App\Repositories;

use App\Models\Icon;
use App\Models\OpenWeatherData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class IconRepository extends BaseRepository
{
    protected function getModelClass(): string
    {
        return Icon::class;
    }

    public function getIconsPath($icons)
    {
        return $this->model
            ->whereIn('name', $icons)
            ->pluck('path')
            ->toArray();
    }
}
