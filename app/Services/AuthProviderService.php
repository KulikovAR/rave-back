<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Traits\BearerTokenTrait;
use Laravel\Socialite\Two\User as UserSocialite;
use Illuminate\Support\Str;

class AuthProviderService
{
    use BearerTokenTrait;

    public function authenticate(UserSocialite $data)
    {
        $email = Str::lower($data->email);

        $user = User::withTrashed()->whereEmail($email)->first();

        if ($user?->trashed()) {
            return redirect(config('front-end.front_url'));
        }

        if ($user && empty($user->email_verified_at)) {
            $user->email_verified_at = now();
            $user->save();
        }

        if (empty($user)) {
            $user                    = new User;
            $user->email             = $email;
            $user->email_verified_at = now();
            $user->language          = empty($data->user['locale'])
                ? config('app.locale')
                : strtolower(substr($data->user['locale'], 0, 2));

            $user->save();

            $user->assignRole(Role::ROLE_USER);
        }

        $bearerToken = $this->createAuthToken($user);
        $cookieToken = $this->createBearerCookie($bearerToken);

        return redirect(config('front-end.auth_provider'))->withCookie($cookieToken);
    }
}