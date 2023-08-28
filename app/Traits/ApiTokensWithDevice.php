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
     * с@param  string  $name
     * @param  array  $abilities
     * @param  \DateTimeInterface|null  $expiresAt
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function createOrGetToken(string $tokenName, array $abilities = ['*'], DateTimeInterface $expiresAt = null)
    {
        $token = $this->tokens()->where('name', $tokenName)->first();

        if(!is_null($token)) {
            $token->delete();
        }
        
       return $this->createToken($tokenName, expiresAt: $expiresAt);
    }
}