<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Requests\GetStatisticsRequest;
use App\Services\Statistics\GetStatisticsService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class GetStatisticsController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __invoke(GetStatisticsRequest $getStatisticsRequest)
    {
        return (new GetStatisticsService())->get($getStatisticsRequest->city_id);
    }
}
