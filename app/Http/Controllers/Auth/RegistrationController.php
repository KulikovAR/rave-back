<?php

namespace App\Http\Controllers\Auth;

use App\Enums\EnvironmentTypeEnum;
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
use Carbon\Carbon;
use hisorange\BrowserDetect\Parser as Browser;
use Illuminate\Support\Facades\App;
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

        $user->userProfile()
            ->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'firstname' => $request->firstname,
                    'lastname'  => $request->lastname
                ]
            );
   
        $bearerToken = $this->createOrGetAuthToken($user, Browser::userAgent());

        event(new RegisteredUserEvent($user));

        Auth::login($user); //session login

        if (!App::environment(EnvironmentTypeEnum::productEnv())) {
           $user->update([
                'subscription_expires_at' => Carbon::now()->addMonth()
           ]); 
        }

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