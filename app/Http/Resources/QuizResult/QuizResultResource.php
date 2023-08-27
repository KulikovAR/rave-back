<?php

namespace App\Http\Resources\QuizResult;

use App\Http\Resources\Quiz\QuizResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'quiz' => new QuizResource($this->quiz),
            'data' => $this->data ? json_decode($this->data) : []
        ];
    }
}
