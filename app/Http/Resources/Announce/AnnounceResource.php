<?php

namespace App\Http\Resources\Announce;

use App\Traits\DateFormats;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnounceResource extends JsonResource
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
            'id'           => $this->id,
            'title'        => $this->title,
            'description'  => $this->description,
            'video_path'   => $this->video_path,
            'preview_path' => $this->preview_path ? url('storage/'.$this->preview_path) : null,
            'release_at'   => $this->formatDateTimeForOutput($this->release_at),
            'main'         => (bool)$this->main
        ];
    }
}