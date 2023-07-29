<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bank\BankRequest;
use App\Http\Requests\UuidRequest;
use App\Http\Resources\BankCollection;
use App\Http\Resources\BankResource;
use App\Http\Responses\ApiJsonResponse;

class BankController extends Controller
{
    public function index(UuidRequest $request)
    {
        if ($this->isModelIdRequest($request)) {
            return $this->show($request);
        }

        $collection = $request->user()
                              ->banks()
                              ->orderBy('updated_at', 'desc')
                              ->paginate(config('pagination.per_page'));

        return (new BankCollection($collection));
    }

    public function show(UuidRequest $request)
    {
        $model = $request->user()->banks()->findOrFail($request->id);

        return new ApiJsonResponse(data: new BankResource($model));
    }

    public function store(BankRequest $request)
    {
        $model = $request->user()->banks()->create(
            $request->validated()
        );

        return new ApiJsonResponse(data: new BankResource($model));
    }

    public function update(BankRequest $request)
    {
        $model = $request->user()->banks()->findOrFail($request->id)->updateOrCreate(
            ['id' => $request->id],
            $request->validated()
        );

        return new ApiJsonResponse(data: new BankResource($model));
    }

    public function destroy(UuidRequest $request)
    {
        $request->user()->banks()->findOrFail($request->id)->delete();

        return new ApiJsonResponse();
    }
}
