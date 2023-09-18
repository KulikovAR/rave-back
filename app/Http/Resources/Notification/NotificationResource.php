<?php

namespace App\Http\Resources\Notification;

use App\Traits\DateFormats;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'id'         => $this->id,
            'data'       => $this->data,
            'read_at'    => $this->readed_at,
            'created_at' => $this->formatDateTimeForOutput($this->created_at)
        ];
    }
}