<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                      => $this->id,
            'email'                   => $this->email,
            'email_verified'          => $this->email_verified_at,
            'subscription_available'  => $this->subscriptionAvailable(),
            'subscription_expires_at' => $this->subscription_expires_at,
            'profile'                 => new UserProfileResource($this->userProfile),
        ];
    }
}