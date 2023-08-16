<?php

namespace App\Http\Resources\Lesson;

use App\Http\Resources\LessonAddictionalData\LessonAddictionalDataCollection;
use App\Http\Resources\Tag\TagCollection;
use App\Http\Resources\Tag\TagResource;
use App\Traits\DateFormats;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    use DateFormats;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title'            => $this->title,
            'description'      => $this->description,
            'video_path'       => $this->video_path,
            'preview_path'     => $this->preview_path,
            'announc_date'     => $this->formatDateForOutput($this->announc_date),
            'tags'             => new TagCollection($this->tags),
            'addictional_data' => new LessonAddictionalDataCollection($this->lesson_addictional_data)
        ];
    }
}