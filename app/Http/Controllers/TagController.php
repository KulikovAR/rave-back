<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagSlugRequest;
use App\Http\Resources\Tag\TagCollection;
use App\Http\Resources\Tag\TagLessonResource;
use App\Http\Responses\ApiJsonResponse;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(): ApiJsonResponse
    {
        return new ApiJsonResponse(
            data: new TagCollection(
                Tag::orderBy('updated_at', 'desc')->get()
            )
        );
    }

    public function show(TagSlugRequest $request): ApiJsonResponse
    {
        $tag = Tag::where(['slug' => $request->slug])->firstOrFail();

        $tag->setRelation('lessons', $request->user()->lessons()->whereHas('tags', function ($q) use ($request) {
            $q->where('slug', $request->slug);
        }));

        return new ApiJsonResponse(
            data: new TagLessonResource(
                Tag::orderBy('updated_at', 'desc')->where(['slug' => $request->slug])->first()
            )
        );
    }
}
