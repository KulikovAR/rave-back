<?php

namespace App\Http\Controllers\Partners;

use App\Http\Controllers\Controller;
use App\Http\Requests\Promocodes\PromocodeRequest;
use App\Http\Requests\UuidRequest;
use App\Http\Resources\BankResource;
use App\Http\Resources\PromoCodeCollection;
use App\Http\Resources\PromoCodeResource;
use App\Http\Responses\ApiJsonResponse;

class PromoCodeController extends Controller
{
    public function index(UuidRequest $request)
    {
        if ($this->isModelIdRequest($request)) {
            return $this->show($request);
        }

        $collection = $request->user()
                              ->promoCodes()
                              ->orderBy('created_at', 'desc')
                              ->paginate(config('pagination.per_page'));

        return (new PromoCodeCollection($collection));
    }

    public function show(UuidRequest $request)
    {
        $model = $request->user()->promoCodes()->with('orders')->findOrFail($request->id);

        return new ApiJsonResponse(data: new PromoCodeResource($model));
    }

    public function store(PromocodeRequest $request)
    {
        if ($request->user()->is_partner !== true) {
            return new ApiJsonResponse(403);
        }

        $model = $request->user()->promoCodes()->create(
            $request->validated()
        );

        return new ApiJsonResponse(data: new PromoCodeResource($model));
    }

    public function update(PromocodeRequest $request)
    {
        $model = $request->user()->promoCodes()->findOrFail($request->id)->updateOrCreate(
            ['id' => $request->id],
            $request->validated()
        );

        return new ApiJsonResponse(data: new BankResource($model));
    }

    public function destroy(UuidRequest $request)
    {
        $request->user()->promoCodes()->findOrFail($request->id)->delete();

        return new ApiJsonResponse();
    }
}
