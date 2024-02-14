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

    const STATISTIC_GROUP_BY_NAMES = [
        self::STATISTIC_GROUP_BY_DAILY,
        self::STATISTIC_GROUP_BY_MONTHLY,
        self::STATISTIC_GROUP_BY_YEARLY
    ];

    const STATISTIC_GROUP_BY_DAILY = 'day';
    const STATISTIC_GROUP_BY_MONTHLY = 'month';
    const STATISTIC_GROUP_BY_YEARLY = 'year';
}
