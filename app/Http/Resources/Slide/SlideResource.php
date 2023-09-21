<?php

namespace App\Http\Resources\Slide;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SlideResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'short_id'   => $this->short_id,
            'image'      => config('app.url') . '/storage/' . $this->image,
            'video_path' => config('app.url') . '/storage/video/' . $this->video_path,
            'created_at' => $this->created_at,
            'updated_at' => $this->update_at,
        ];
    }
}
