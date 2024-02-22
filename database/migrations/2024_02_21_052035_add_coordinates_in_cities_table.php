<?php

use App\Models\City;
use App\Services\OpenWeatherService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach (City::all() as $city) {
            $coordinateCity = (new OpenWeatherService())->geocodingApi($city->name, $city->country_code);
            City::find($city->id)->update([
                'latitude' => $coordinateCity[0]['lat'],
                'longitude' => $coordinateCity[0]['lon'],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            //
        });
    }
};
