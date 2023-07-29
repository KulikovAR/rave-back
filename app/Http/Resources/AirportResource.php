<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AirportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'code'    => $this->code,
            'name'    => $this->name,
            'name_en' => $this->name_en,
            'type'    => $this->type,
            'weight'  => $this->weight,
            'country' => $this->country,
            'city'    => $this->city,
            'city_en' => $this->city_en,
        ];
    }
}
