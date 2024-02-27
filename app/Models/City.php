<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'country_code',
        'open_weather_city_id',
        'latitude',
        'longitude'
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_code', 'two_letters_code');
    }

    public function open_weather_data(): HasMany
    {
        return $this->hasMany(OpenWeatherData::class, 'city_id', 'open_weather_city_id');
    }
}
