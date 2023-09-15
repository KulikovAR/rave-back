<?php

namespace App\Http\Resources\Quiz;

use App\Enums\QuizResultStatusEnum;
use App\Traits\QuizFormat;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
{
    use QuizFormat;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'duration'    => $this->duration,
            'data'        => $this->data ? $this->formatQuizForClient($this->data) : [],
            'quiz_result' => $this->quiz_result ? $this->quiz_result->getQuizResultStatus() : QuizResultStatusEnum::NOT_PASSED->value
        ];
    }
}