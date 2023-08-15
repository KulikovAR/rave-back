<?php

namespace App\Http\Controllers;

use App\Http\Resources\Tag\TagCollection;
use App\Http\Responses\ApiJsonResponse;
use App\Models\Tag;

class TagController extends Controller
{
    public function index()
    {
        return new ApiJsonResponse(
            data: new TagCollection(
                Tag::orderBy('updated_at', 'desc')->get()
            )
        );
    }
}
