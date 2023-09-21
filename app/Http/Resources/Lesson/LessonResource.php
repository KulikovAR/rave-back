<?php

namespace App\Http\Resources\Lesson;

use App\Docs\Schemas\Lesson\Lesson;
use App\Http\Resources\LessonAdditionalData\LessonAdditionalDataCollection;
use App\Http\Resources\Quiz\QuizLessonCollection;
use App\Http\Resources\Tag\TagCollection;
use App\Traits\DateFormats;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

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
            'id'             => $this->id,
            'title'          => $this->title,
            'description'    => $this->description,
            'video_path'     => config('app.url') . '/storage/video/' . $this->video_path,
            'preview_path'   => URL::temporarySignedRoute(
                'storage.file',
                Carbon::now()->addMinutes(1),
                [
                    'user_id'   => auth('sanctum')->user()->id,
                    'model_id'   => $this->id,
                    'model_type'   => Lesson::class,
                    'path' => $this->preview_path,
                ]
            ),
            'duration'       => (int)$this->duration,
            'rating'         => (float) $this->getRating(),
            'tags'           => new TagCollection($this->tags),
            'quiz'           => new QuizLessonCollection($this->quizzes),
            'comments_count' => $this->comments()->count()
        ];
    }
}