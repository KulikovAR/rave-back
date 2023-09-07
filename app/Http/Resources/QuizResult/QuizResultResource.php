<?php

namespace App\Http\Resources\QuizResult;

use App\Http\Resources\Quiz\QuizResource;
use App\Traits\QuizResultStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResultResource extends JsonResource
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
            'quiz'               => new QuizResource($this->quiz),
            'data'               => $this->data ? json_decode($this->data) : [],
            'curator_comment'    => $this->curator_comment,
            'quiz_result_status' => $this->getQuizResultStatus()
        ];
    }
}