<?php

namespace App\Http\Controllers;

use App\Http\Requests\UuidRequest;
use App\Http\Resources\Quiz\QuizCollection;
use App\Http\Resources\Quiz\QuizResource;
use App\Http\Responses\ApiJsonPaginationResponse;
use App\Http\Responses\ApiJsonResponse;
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
       $lesson = $request->user()->lessons()->findOrFail($request->lesson_id);

       return new ApiJsonResponse(
            data: new QuizCollection($lesson->quizzes)
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
