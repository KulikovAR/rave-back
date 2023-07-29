<?php

namespace App\Http\Controllers\Auth;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginEmailRequest;
use App\Http\Responses\ApiJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthSessionController extends Controller
{
    public function store(LoginEmailRequest $request): ApiJsonResponse
    {
        $passwordCheckCallable = function ($email, $password, $rememberMe) {
            return Auth::attempt(['email' => Str::lower($email), 'password' => $password], $rememberMe);
        };

        $request->authenticate($passwordCheckCallable);

        $request->session()->regenerate();

        return new ApiJsonResponse();
    }

    public function destroy(Request $request): ApiJsonResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return new ApiJsonResponse();
    }
}