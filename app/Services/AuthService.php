<?php

namespace App\Services;

use App\Contracts\AuthServiceContract;
use App\Enums\TokenEnum;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RefreshRequest;
use App\Http\Requests\Auth\VerifyRequest;
use App\Http\Responses\ApiJsonResponse;
use App\Models\AccessToken;
use App\Models\User;
use Carbon\Carbon;

class AuthService implements AuthServiceContract
{
    public function login(LoginRequest $request): ApiJsonResponse
    {
        $data = [];

        $user = User::firstOrCreate(['phone' => $request->phone], ['phone' => $request->phone]);
        $code = $this->sendCode($user);

        if (env('APP_ENV') != 'production') {
            $data['code'] = $code;
        }

        return new ApiJsonResponse(data: $data);
    }

    public function verify(VerifyRequest $request): ApiJsonResponse
    {
        $user = User::firstOrCreate(['phone' => $request->phone], ['phone' => $request->phone]);

        if (md5($request->code) != $user->code) {
            return new ApiJsonResponse(403, false, __('Неверный код из смс.'));
        }

        $response = $this->createTokens($user);

        return new ApiJsonResponse(data: [$response]);
    }

    public function refresh(RefreshRequest $request): ApiJsonResponse
    {
        $response = $this->createAccessToken($request->user());

        return new ApiJsonResponse(data: [$response]);
    }

    public function logout(User $user): void
    {
        AccessToken::where('tokenable_id', $user->id)->delete();
    }

    public function clearVerificationCodes(): void
    {
        User::whereNotNull('code')->where('code_send_at', '<', Carbon::now()->subMinutes(config('auth.code_expires')))->delete();
    }

    private function createTokens(User $user): array
    {
        return [
            'refreshToken'   => $user->createToken('refresh_token', [TokenEnum::REFRESH->value], Carbon::now()->addMinutes(config('auth.refresh_token_expires'))),
            'expiredRefresh' => Carbon::now()->addMinutes(config('auth.refresh_token_expires'))->toISOString(),
        ] + $this->createAccessToken($user);
    }

    private function createAccessToken(User $user): array
    {
        return [
            'token'   => $user->createToken('access_token', [TokenEnum::ACCESS->value], Carbon::now()->addMinutes(config('auth.access_token_expires'))),
            'expired' => Carbon::now()->addMinutes(config('auth.access_token_expires'))->toISOString(),
        ];
    }

    private function sendCode(User $user)
    {
        $code = rand(10000, 99999);

        $user->update([
            'code'         => md5($code),
            'code_send_at' => now(),
        ]);

        return $code;
    }
}
