<?php

namespace App\Http\Resources\Lesson;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title'        => $this->title,
            'description'  => $this->description,
            'video_path'   => $this->video_path,
            'preview_path' => $this->preview_path,
            'announc_date' => Carbon::parse($this->announc_date)->format('Y-m-d'),
            'tags'         => $this->tags
        ];
    }
}