<?php

namespace App\Http\Controllers;

use App\Http\Requests\Lesson\LessonRequest;
use App\Http\Resources\Lesson\LessonResource;
use App\Http\Responses\ApiJsonResponse;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function index(LessonRequest $request) {
        if($request->has('id')) {
            return new ApiJsonResponse(data: new LessonResource(Lesson::find($request->id)));
        }

        return new ApiJsonResponse(data: LessonResource::collection($request->user()->lessons()->paginate(15)));
    }
}
