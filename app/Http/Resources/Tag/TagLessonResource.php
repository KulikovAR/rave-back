<?php

namespace App\Http\Resources\Tag;

use App\Http\Resources\Lesson\LessonPaginationCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagLessonResource extends JsonResource
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
            'image'         => Storage::disk('public')->url($this->image),
            'lessons_count' => $request->user()->lessons()->whereHas('tags', function ($q) {
                $q->where('slug', $this->slug);
            })->count(),
            'lessons'       => new LessonPaginationCollection(
                $this->lessons()->paginate(config('pagination.per_page'), ['*'], 'lesson_page')
            )
        ];
    }
}