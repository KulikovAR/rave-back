<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\UserProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'user_id'          => $this->user_id,
            'body'             => $this->body,
            'user'             => new UserProfileResource($this->user->userProfile),
            'nesting_comments' => new CommentNestingCommentsCollection($this->nesting_comments)
        ];
    }
}