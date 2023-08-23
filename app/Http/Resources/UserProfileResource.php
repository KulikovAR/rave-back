<?php

namespace App\Http\Resources;

use App\Traits\DateFormats;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    use DateFormats;

    public function toArray(Request $request): array
    {
        return [
            'firstname'        => $this->firstname,
            'lastname'         => $this->lastname,
        ];
    }
}
