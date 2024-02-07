<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Requests\GetStatisticsRequest;
use App\Http\Resources\Statistics\GetAverageResource;
use App\Services\Statistics\GetAverageStatisticsService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class GetAverageStatisticsController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __invoke(GetStatisticsRequest $getStatisticsRequest)
    {
        return GetAverageResource::collection((new GetAverageStatisticsService())->get($getStatisticsRequest->city_id));
    }
}
