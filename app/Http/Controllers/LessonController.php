<?php

namespace App\Http\Controllers;

use App\Http\Requests\UuidRequest;
use App\Http\Resources\Lesson\LessonCollection;
use App\Http\Resources\Lesson\LessonResource;
use App\Http\Responses\ApiJsonPaginationResponse;
use App\Http\Responses\ApiJsonResponse;

class LessonController extends Controller
{
    public function index(UuidRequest $request) {

        if($request->has('id')) {
            return new ApiJsonResponse(data: new LessonResource($request->user()->lessons()->findOrFail($request->id)));
        }

        return new ApiJsonPaginationResponse(
            data: new LessonCollection(
                $request->user()->lessons()->orderBy('updated_at', 'desc')->paginate(config('pagination.per_page'))
            )
        );
    }
}
