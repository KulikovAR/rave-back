<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginEmailRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiJsonResponse;
use App\Models\User;
use App\Traits\BearerTokenTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthTokenController extends Controller
{
    use BearerTokenTrait;

    public function store(LoginEmailRequest $request): ApiJsonResponse
    {
        $passwordCheckCallable = function ($email, $password) {
            $user = User::where('email', Str::lower($email))->first();
            return $user && Hash::check($password, $user->password);
        };

        $request->authenticate($passwordCheckCallable);

        $user        = User::where('email', Str::lower($request->email))->first();
        $bearerToken = $this->createAuthToken($user, $request->device_name);

        return new ApiJsonResponse(
            data: [
                      'user'  => new UserResource($user),
                      'token' => $bearerToken,
                  ]);
    }

    public function destroy(Request $request): ApiJsonResponse
    {
        $request->user()->tokens()->delete();

        return new ApiJsonResponse();
    }
}