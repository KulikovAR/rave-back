<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreditCard\CreditCardRequest;
use App\Http\Requests\UuidRequest;
use App\Http\Resources\CreditCardCollection;
use App\Http\Resources\CreditCardResource;
use App\Http\Responses\ApiJsonResponse;

class CreditCardController extends Controller
{
    public function index(UuidRequest $request)
    {
        if ($this->isModelIdRequest($request)) {
            return $this->show($request);
        }

        $collection = $request->user()
                              ->creditCards()
                              ->orderBy('updated_at', 'desc')
                              ->paginate(config('pagination.per_page'));

        return (new CreditCardCollection($collection));
    }

    public function show(UuidRequest $request)
    {
        $model = $request->user()->creditCards()->findOrFail($request->id);

        return new ApiJsonResponse(data: new CreditCardResource($model));
    }

    public function store(CreditCardRequest $request)
    {
        $model = $request->user()->creditCards()->create(
            $request->validated()
        );

        return new ApiJsonResponse(data: new CreditCardResource($model));
    }

    public function update(CreditCardRequest $request)
    {
        $model = $request->user()->creditCards()->findOrFail($request->id)->updateOrCreate(
            ['id' => $request->id],
            $request->validated()
        );

        return new ApiJsonResponse(data: new CreditCardResource($model));
    }

    public function destroy(UuidRequest $request)
    {
        $request->user()->creditCards()->findOrFail($request->id)->delete();

        return new ApiJsonResponse();
    }
}
