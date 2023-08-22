<?php

namespace App\Http\Resources\Tag;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'          => $this->name,
            'slug'          => $this->slug,
            'image'         => $this->image,
            'lessons_count' => $request->user()->lessons()->whereHas('tags', function ($q) {
                $q->where('slug', $this->slug);
            })->count()
        ];
    }
}