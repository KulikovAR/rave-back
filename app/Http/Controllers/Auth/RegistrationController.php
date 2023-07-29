<?php

namespace App\Http\Controllers\Auth;

use App\Enums\StatusEnum;
use App\Events\RegisteredUserEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistrationEmailRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiJsonResponse;
use App\Models\Role;
use App\Models\User;
use App\Traits\BearerTokenTrait;
use App\Traits\PasswordHash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    use BearerTokenTrait;
    use PasswordHash;

    public function emailRegistration(RegistrationEmailRequest $request): ApiJsonResponse
    {
        $user = User::create([
                                 'email'    => Str::lower($request->email),
                                 'password' => $this->hashMake($request->password),
                             ]);

        $user->assignRole(Role::ROLE_USER);

        $bearerToken = $this->createAuthToken($user, $request->device_name);

        event(new RegisteredUserEvent($user));

        Auth::login($user); //session login

        return new ApiJsonResponse(
                  200,
                  StatusEnum::OK,
                  __('registration.verify_email'),
            data: [
                      'user'  => new UserResource($user),
                      'token' => $bearerToken,
                  ]
        );
    }
}
