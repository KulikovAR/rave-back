<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthProviderRequest;
use App\Services\AuthProviderService;
use Laravel\Socialite\Facades\Socialite;

class AuthProviderController extends Controller
{
    private AuthProviderService $authProvider;

    public function __construct(AuthProviderService $authProvider)
    {
        $this->authProvider = $authProvider;
    }

    public function redirectToProvider(AuthProviderRequest $request)
    {
        $providerName = $request->validated();
        $urlRedirect  = url(route('provider.callback', $providerName));
        return Socialite::driver($providerName)->redirectUrl($urlRedirect)->stateless()->redirect();
    }

    public function loginOrRegister(AuthProviderRequest $request)
    {
        $providerName = $request->validated();
        $userData     = Socialite::driver($providerName)->stateless()->user();

        return $this->authProvider->authenticate($userData);
    }
}