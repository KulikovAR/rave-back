<?php

namespace App\Http\Resources\Quiz;

use App\Enums\QuizResultStatusEnum;
use App\Traits\QuizResultStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizLessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->id,
            'title'              => $this->title,
            'description'        => $this->description,
            'duration'           => $this->duration,
            'quiz_result_status' => $this->quiz_result ? $this->quiz_result->getQuizResultStatus() : QuizResultStatusEnum::NOT_PASSED->value
        ];
    }
}