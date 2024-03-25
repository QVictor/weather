<?php

namespace App\Http\Resources\Statistics;

use App\Repositories\IconRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GetStatisticWithIconsResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'city_id' => $this->city_id,
            'city_name' => $this->city->name,
            'date' => $this->created_at,
            'week_day' => Carbon::create($this->created_at)->locale('ru')->minDayName,
            'icons' => $this->getIconPaths($this->icons),
            'min_temp' => $this->min_temp,
            'max_temp' => $this->max_temp,
            'avg_wind_speed' => $this->avg_wind_speed,
            'avg_humidity' => (int)$this->avg_humidity,
        ];
    }

    private function getIconPaths(string $iconNames)
    {
        return (new IconRepository())->getIconsPath(explode(',', $iconNames));
    }
}
