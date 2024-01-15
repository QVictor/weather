<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpenWeatherData extends Model
{
    use HasFactory;

    protected $table = 'open_weather_data';

    public function city():BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'open_weather_city_id');
    }
}
