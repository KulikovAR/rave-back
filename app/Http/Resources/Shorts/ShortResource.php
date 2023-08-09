<?php

namespace App\Http\Resources\Shorts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShortResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title'       => $this->title,
            'slide_count' => $this->slides()->count(),
            'view_count'  => $this->view_count,
            'video'       => $this->video,
            'slide'       => $this->slides
        ];
    }

}