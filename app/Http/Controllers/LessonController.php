<?php

namespace App\Http\Controllers;

use App\Http\Requests\UuidRequest;
use App\Http\Resources\Lesson\LessonCollection;
use App\Http\Resources\Lesson\LessonResource;
use App\Http\Resources\Lesson\LessonShowResource;
use App\Http\Responses\ApiJsonResponse;

class LessonController extends Controller
{
    public function index(UuidRequest $request) {

        if($request->has('id')) {
            $lesson = $request->user()->lessons()->findOrFail($request->id);
            if($lesson->quiz) {
                $lesson->quiz->setRelation('quiz_result', $lesson->quiz->quiz_results()->where('user_id', $request->user()->id)->first());
            }
    
            return new ApiJsonResponse(data: new LessonShowResource($lesson));
        }

        return new LessonCollection($request->user()->lessons()->orderBy('updated_at', 'desc')->paginate(config('pagination.per_page')));
    }
}
