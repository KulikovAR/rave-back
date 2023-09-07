<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UuidRequest;
use App\Http\Responses\ApiJsonResponse;

class BannerController extends Controller
{
    public function index(Request $request) {

        
        return new ApiJsonResponse(data: ['test' => 'test']);

        if ($request->has('id')) {
            $lesson = $request->user()->lessons()->findOrFail($request->id);
            if($lesson->quiz) {
                $lesson->quiz->setRelation('quiz_result', $lesson->quiz->quiz_results()->where('user_id', $request->user()->id)->first());
            }
    
            return new ApiJsonResponse(data: new LessonShowResource($lesson));
        }

        return new LessonCollection($request->user()->lessons()->orderBy('updated_at', 'desc')->paginate(config('pagination.per_page')));
    }
}
