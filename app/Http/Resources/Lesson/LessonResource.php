<?php

namespace App\Http\Resources\Lesson;

use App\Http\Resources\LessonAdditionalData\LessonAdditionalDataCollection;
use App\Http\Resources\Quiz\QuizLessonCollection;
use App\Http\Resources\Tag\TagCollection;
use App\Traits\DateFormats;
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
            'id'              => $this->id,
            'title'           => $this->title,
            'description'     => $this->description,
            'video_path'      => $this->video_path,
            'preview_path'    => $this->preview_path,
            'announc_date'    => $this->formatDateForOutput($this->announc_date),
            'rating'          => (float)$this->getRating(),
            'tags'            => new TagCollection($this->tags),
            'additional_data' => new LessonAdditionalDataCollection($this->lesson_additional_data),
            'quiz'            => new QuizLessonCollection($this->quizzes)
        ];
    }
}