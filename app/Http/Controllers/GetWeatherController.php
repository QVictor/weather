<?php

namespace App\Http\Controllers;

use App\Services\OpenWeatherService;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class GetWeatherController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __invoke()
    {
        return (new OpenWeatherService())->receiveAndSaveData();
    }
}
