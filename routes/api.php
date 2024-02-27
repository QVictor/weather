<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getWeather', App\Http\Controllers\GetWeatherController::class);
Route::get('/cities', App\Http\Controllers\CitiesController::class);

Route::prefix('/statistic/get-statistics')->group(function () {
    Route::get('{cityId}', App\Http\Controllers\Statistics\GetStatisticsController::class);
    Route::get('{cityId}/average', App\Http\Controllers\Statistics\GetAverageStatisticsController::class);
    Route::get('{cityId}/air-pollution', App\Http\Controllers\Statistics\GetAirPollutionStatisticsController::class);
});

