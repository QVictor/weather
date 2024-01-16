<?php

namespace App\Http\Controllers;

use App\Http\Resources\CitiesResource;
use App\Models\City;
use App\Services\CitiesService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class CitiesController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __invoke()
    {
        return CitiesResource::collection(City::all());
    }
}
