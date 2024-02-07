<?php

namespace App\Http\Resources\Statistics;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GetAverageResource extends JsonResource
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
            'avg_temp' => $this->avg_temp,
            'avg_wind_speed' => $this->avg_wind_speed,
            'avg_humidity' => (int)$this->avg_humidity,
            'date' => $this->date
        ];
    }
}
