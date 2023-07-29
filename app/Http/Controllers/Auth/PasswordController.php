<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Pass\ResetPasswordRequest;
use App\Http\Requests\Auth\Pass\UpdatePasswordRequest;
use App\Http\Responses\ApiJsonResponse;
use App\Models\User;
use App\Traits\PasswordHash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;

class PasswordController extends Controller
{
    use PasswordHash;

    public function sendPasswordLink(Request $request): ApiJsonResponse
    {
        $request->validate([
                               'email' => ['required', 'email', Rule::exists('users', 'email')],
                           ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return new ApiJsonResponse(message: __($status));
    }

    public function store(ResetPasswordRequest $request): ApiJsonResponse
    {
        $status = Password::reset(
            $request->validated(),
            function ($user) use ($request) {
                $user->forceFill([
                                     'password' => $this->hashMake($request->password),
                                 ])->save();
            }
        );

        return new ApiJsonResponse(message: __($status));
    }

    public function update(UpdatePasswordRequest $request): ApiJsonResponse
    {
        $request->user()
                ->forceFill([
                                'password' => $this->hashMake($request->password),
                            ])->save();

        return new ApiJsonResponse(message: __('registration.password_updated')
        );
    }
}