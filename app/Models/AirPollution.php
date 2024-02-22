<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AirPollution extends Model
{
    use HasFactory, HasTimestamps;

    protected $table = 'air_pollution';

    public function city():BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'open_weather_city_id');
    }
}
