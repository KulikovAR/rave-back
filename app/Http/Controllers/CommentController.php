<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentLessonRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Requests\UuidRequest;
use App\Http\Resources\Comment\CommentCollection;
use App\Http\Responses\ApiJsonResponse;
use App\Models\Comment;
use App\Models\Lesson;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UuidRequest $request)
    {
        $lesson = $request->user()->lessons()->findOrFail($request->lesson_id);

        return new CommentCollection(
            $lesson->comments()->orderBy('updated_at', 'desc')->paginate(config('pagination.per_page'))
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentLessonRequest $request)
    {
        $lesson = $request->user()->lessons()->findOrFail($request->lesson_id);

        $comment = new Comment([
            'body'    => $request->body,
            'user_id' => $request->user()->id
        ]);

        $lesson->comments()->save($comment);

        return new ApiJsonResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UuidRequest $request)
    {
        $comment = Comment::where([
            'user_id' => $request->user()->id,
            'id' => $request->id
        ])->firstOrFail();

        $comment->delete();

        return new ApiJsonResponse();
    }
}