<?php

namespace App\Http\Controllers;

use App\Http\Requests\Lesson\LessonRatingRequest;
use App\Http\Requests\UuidRequest;
use App\Http\Responses\ApiJsonResponse;
use App\Models\LessonRating;
use Illuminate\Http\Request;

class LessonRatingController extends Controller
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
    public function store(LessonRatingRequest $request)
    {
        $lesson = $request->user()->lessons()->findOrFail($request->lesson_id);

        LessonRating::updateOrCreate(
            [
                'lesson_id' => $lesson->id,
                'user_id'   => $request->user()->id
            ],
            [
                'rating'    => $request->rating,
                'lesson_id' => $lesson->id,
                'user_id'   => $request->user()->id
            ]
        );

        return new ApiJsonResponse(data: [
            'rating' => $lesson->getRating()
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(UuidRequest $request)
    {
        $lesson = $request->user()->lessons()->findOrFail($request->lesson_id);

        return new ApiJsonResponse(data: [
            'rating' => $lesson->getRating()
        ]);
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
    public function destroy(UuidRequest $request)
    {
        $lesson_rating = $request->user()->lesson_rating()->where('lesson_id', $request->lesson_id)->firstOrFail();
        
        $lesson_rating->delete();

        return new ApiJsonResponse();
    }
}