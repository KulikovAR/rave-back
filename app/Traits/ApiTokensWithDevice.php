<?php

namespace App\Traits;

use DateTimeInterface;
use Illuminate\Support\Facades\Crypt;
use Laravel\Sanctum\NewAccessToken;
use Illuminate\Support\Str;

trait ApiTokensWithDevice
{
    /**
     * Create a new personal access token for the user.
     *
     * @param  string  $name
     * @param  array  $abilities
     * @param  \DateTimeInterface|null  $expiresAt
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function createOrGetToken(string $name, string $device_name, array $abilities = ['*'], DateTimeInterface $expiresAt = null)
    {
        $token = $this->tokens()->where('device_name', $device_name)->first();

        if(!is_null($token)) {
            return new NewAccessToken($token, $token->getKey() . '|' . Crypt::decrypt($token->token));
        }
        
        $token = $this->tokens()->create([
            'name'        => $name,
            'token'       => hash('sha256', $plainTextToken = Str::random(40)),
            'abilities'   => $abilities,
            'expires_at'  => $expiresAt,
            'device_name' => $device_name
        ]);

        return new NewAccessToken($token, $token->getKey() . '|' . $plainTextToken);
    }
}