<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenWeatherData extends Model
{
    use HasFactory;

    protected $table = 'open_weather_data';
}
