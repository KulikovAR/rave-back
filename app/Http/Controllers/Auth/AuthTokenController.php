<?php

namespace App\Http\Controllers\Auth;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginEmailRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiJsonResponse;
use App\Models\User;
use App\Services\UserDeviceService;
use App\Traits\BearerTokenTrait;
use hisorange\BrowserDetect\Parser as Browser;
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

        $user              = User::where('email', Str::lower($request->email))->first();
        $userDeviceService = new UserDeviceService($user);

        if ($userDeviceService->checkTooManyDevices(Browser::userAgent())) {
            return new ApiJsonResponse(
                status: StatusEnum::ERR,
                data: [
                    'devices' => $userDeviceService->getDevices(),
                    'user'    => new UserResource($user),
                    'token'   => $this->createOrGetAuthToken($user, Browser::userAgent()),
                ]
            );
        }

        return new ApiJsonResponse(
            data: [
                'user'  => new UserResource($user),
                'token' => $this->createOrGetAuthToken($user, Browser::userAgent()),
            ]
        );
    }

    public function destroy(Request $request): ApiJsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return new ApiJsonResponse();
    }
}