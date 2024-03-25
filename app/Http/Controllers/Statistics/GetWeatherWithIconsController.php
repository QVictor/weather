<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Requests\GetAirPollutionRequest;
use App\Http\Resources\Statistics\GetStatisticWithIconsResource;
use App\Repositories\OpenWeatherDataRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class GetWeatherWithIconsController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __invoke(GetAirPollutionRequest $getStatisticsRequest)
    {
        $res = (new OpenWeatherDataRepository())->getStatisticWithIcons($getStatisticsRequest->cityId);
        return GetStatisticWithIconsResource::collection($res);
    }
}
