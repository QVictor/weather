<?php

namespace App\Http\Resources\Statistics;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GetAirPollutionResource extends JsonResource
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
            'avg_air_quality_index' => $this->avg_air_quality_index,
            'avg_co' => $this->avg_co,
            'avg_so2' => $this->avg_so2,
            'avg_no2' => $this->avg_no2,
            'avg_o3' => $this->avg_o3,
            'avg_pm10' => $this->avg_pm10,
            'avg_pm2_5' => $this->avg_pm2_5,
            'avg_date' => $this->date
        ];
    }
}
