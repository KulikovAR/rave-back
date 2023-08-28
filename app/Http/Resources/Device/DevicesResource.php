<?php

namespace App\Http\Resources\Device;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DevicesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name
        ];
    }
}