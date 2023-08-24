<?php

namespace App\Http\Controllers;

use App\Http\Requests\Quiz\QuizResultRequest;
use App\Http\Responses\ApiJsonResponse;
use App\Models\QuizResult;
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
    public function store(QuizResultRequest $request)
    {
        $quiz_result = QuizResult::create([
            'quiz_id' => $request->quiz_id,
            'user_id' => $request->user()->id,
            'data'    => json_encode($request->data)
        ]);

        return new ApiJsonResponse(
            data: $quiz_result
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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