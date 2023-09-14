<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Requests\Quiz\StoreQuizResultRequest;
use App\Http\Requests\UuidRequest;
use App\Http\Resources\QuizResult\QuizResultResource;
use App\Http\Responses\ApiJsonResponse;
use App\Models\QuizResult;
use App\Notifications\UserAppNotification;
use Illuminate\Http\Request;

class QuizResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizResultRequest $request)
    {
        if (
            $request->user()->quiz_results()->where([
                'quiz_id' => $request->quiz_id,
                'user_id' => $request->user()->id
            ])->first()
        ) {
            return new ApiJsonResponse(
                422,
                StatusEnum::ERR,
                'quiz result already exists'
            );
        }

        $quiz_result = QuizResult::create([
            'quiz_id' => $request->quiz_id,
            'user_id' => $request->user()->id,
            'data' => json_encode($request->data)
        ]);

        $request->user()->notify(new UserAppNotification('Вы прошли тест'));

        return new ApiJsonResponse(
            data: new QuizResultResource($quiz_result)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(UuidRequest $request)
    {
        $quizResultModel = $request->user()->quiz_results()->whereHas('quiz', function ($quiz) use ($request) {
            $quiz->where('id', $request->quiz_id);
        })->firstOrFail();

        return new ApiJsonResponse(
            data: new QuizResultResource(
                $quizResultModel
            )
        );
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