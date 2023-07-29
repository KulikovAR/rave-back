<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Requests\Airports\IndexAirports;
use App\Http\Resources\AirportCollection;
use App\Http\Responses\ApiResourceResponse;
use App\Models\Airport;
use App\Services\RuKeyboardSwitcher;
use Illuminate\Support\Str;

class AirportsController extends Controller
{
    public function index(IndexAirports $request)
    {
        $input         = Str::lower($request->airport);
        $switchedInput = RuKeyboardSwitcher::format($input);

        $airportsCollection = Airport::query()->whereRaw("
        lower(city) like '{$input}%' 
        OR lower(name) like '{$input}%' 
        OR lower(city_en) like '{$input}%' 
        
        OR lower(city) like '{$switchedInput}%' 
        OR lower(name) like '{$switchedInput}%' 
        OR lower(city_en) like '{$switchedInput}%'
        
        OR code = '{$input}'
        OR ( lower(country) like '{$input}%' and type='city')
        ")
                                     ->orderBy('weight', 'desc')
                                     ->limit(15)
                                     ->get();

        return new ApiResourceResponse(
            200,
            StatusEnum::OK,
            "",
            new AirportCollection($airportsCollection)
        );
    }
}
