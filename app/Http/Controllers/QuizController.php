<?php

namespace App\Http\Controllers;

use App\Http\Requests\UuidRequest;
use App\Http\Resources\Quiz\QuizCollection;
use App\Http\Resources\Quiz\QuizResource;
use App\Http\Responses\ApiJsonPaginationResponse;
use App\Http\Responses\ApiJsonResponse;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(UuidRequest $request)
    {
       $quiz = Quiz::whereHas('lessons', function($lesson) use ($request) {
            $lesson->whereHas('users', function($user) use ($request) {
                $user->where('users.id', $request->user()->id);
            });
       })->where('id', $request->id)->firstOrFail();

        $quiz->setRelation('quiz_results', $quiz->quiz_results()->whereHas('user', function ($user) use ($request) {
            $user->where('id', $request->user()->id);
        }));

       return new ApiJsonResponse(
            data: new QuizResource($quiz)
       );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UuidRequest $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
