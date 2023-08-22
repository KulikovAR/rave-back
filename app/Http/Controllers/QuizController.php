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
    public function index(UuidRequest $request)
    {

        if ($request->has('id')) {
            return new ApiJsonResponse(data: new QuizResource($request->user()->lessons()->findOrFail($request->id)));
        }

        return new ApiJsonPaginationResponse(
            data: new QuizCollection(
                $request->user()->lessons()->orderBy('updated_at', 'desc')->paginate(config('pagination.per_page'))
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
