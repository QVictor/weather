<?php

namespace App\Console;

use App\Http\Controllers\GetWeatherController;
use App\Services\OpenWeatherService;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            (new OpenWeatherService())->receiveAndSaveData();
        })->hourly();

        $schedule->call(function () {
            (new OpenWeatherService())->receiveAndSaveAirPollutionData();
        })->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
