<?php

namespace App\Http\Controllers;

use App\Http\Requests\Passengers\PassengerRequest;
use App\Http\Requests\UuidRequest;
use App\Http\Resources\PassengerCollection;
use App\Http\Resources\PassengerResource;
use App\Http\Responses\ApiJsonResponse;

class PassengersController extends Controller
{
    public function index(UuidRequest $request)
    {
        if ($this->isModelIdRequest($request)) {
            return $this->show($request);
        }

        $passengerCollection = $request->user()
                                       ->passenger()
                                       ->orderBy('updated_at', 'desc')
                                       ->paginate(config('pagination.per_page'));

        return (new PassengerCollection($passengerCollection));
    }


    public function show(UuidRequest $request)
    {
        $passengerModel = $request->user()->passenger()->findOrFail($request->id);

        return new ApiJsonResponse(data: new PassengerResource($passengerModel));
    }

    public function store(PassengerRequest $request)
    {
        $passenger = $request->user()->passenger()->create(
            $request->validated()
        );

        return new ApiJsonResponse(data: new PassengerResource($passenger));
    }

    public function update(PassengerRequest $request)
    {
        $passenger = $request->user()->passenger()->findOrFail($request->id)->updateOrCreate(
            ['id' => $request->id],
            $request->validated()
        );

        return new ApiJsonResponse(data: new PassengerResource($passenger));
    }

    public function destroy(UuidRequest $request)
    {
        $request->user()->passenger()->findOrFail($request->id)->delete();

        return new ApiJsonResponse();
    }
}
