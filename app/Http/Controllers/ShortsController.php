<?php

namespace App\Http\Controllers;

use App\Http\Requests\UuidRequest;
use App\Http\Resources\Shorts\ShortCollection;
use App\Http\Resources\Shorts\ShortResource;
use App\Http\Responses\ApiJsonPaginationResponse;
use App\Http\Responses\ApiJsonResponse;
use App\Models\Short;

class ShortsController extends Controller
{
    public function index(UuidRequest $request)
    {
        if ($request->has('id')) {
            return new ApiJsonResponse(data: new ShortResource(Short::findOrFail($request->id)));
        }

        return new ShortCollection(
            Short::orderBy('updated_at', 'desc')->paginate(config('pagination.per_page'))
        );
    }

    public function update(UuidRequest $request)
    {

        $shortModel = Short::findOrFail($request->id);
        $shortModel->increment('view_count');

        return new ApiJsonResponse(data: new ShortResource($shortModel));

    }
}