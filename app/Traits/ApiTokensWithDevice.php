<?php

namespace App\Traits;

use DateTimeInterface;
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

        if (!is_null($token)) {
            $token->delete();
        }

        return $this->createToken($tokenName, expiresAt: $expiresAt);
    }


    /**
     * Create a new temp personal access token for the user.
     *
     * @param  string  $name
     * @param  array  $abilities
     * @param  \DateTimeInterface|null  $expiresAt
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function createTempToken(string $name, array $abilities = ['*'], DateTimeInterface $expiresAt = null)
    {
        $plainTextToken = sprintf(
            '%s%s%s',
            config('sanctum.token_prefix', ''),
            $tokenEntropy = Str::random(40),
            hash('CRC32', $tokenEntropy)
        );

        $token = $this->tokens()->create([
            'name'       => $name,
            'token'      => hash('sha256', $plainTextToken),
            'abilities'  => $abilities,
            'expires_at' => $expiresAt,
            'temp'       => true
        ]);

        return new NewAccessToken($token, $token->getKey() . '|' . $plainTextToken);
    }
}