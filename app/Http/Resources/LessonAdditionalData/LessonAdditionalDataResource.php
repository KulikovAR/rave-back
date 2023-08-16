<?php

namespace App\Http\Resources\LessonAdditionalData;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonAdditionalDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'title' => $this->title,
            'file'  => $this->file
        ];
    }
}