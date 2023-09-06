<?php

namespace App\Http\Resources\Quiz;

use App\Traits\QuizResultStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizLessonResource extends JsonResource
{
    use QuizResultStatus;
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
            'quiz_result_status' => $this->getQuizResultStatus()
        ];
    }
}