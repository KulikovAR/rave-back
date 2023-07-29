<?php

namespace App\Http\Controllers;


use App\Enums\StatusEnum;
use App\Http\Requests\UserProfile\UserProfileRequest;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiJsonResponse;
use App\Http\Responses\ApiResourceResponse;
use Illuminate\Http\Request;
use stdClass;

class UserProfileController extends Controller
{

    public function index(Request $request)
    {
        $user        = $request->user();
        $userProfile = $user->userProfile;

        return new ApiJsonResponse(
            200,
            StatusEnum::OK,
            '',
            [
                'user'    => new UserResource($user),
                'profile' => $userProfile
                    ? new UserProfileResource($user->userProfile)
                    : new stdClass(),
            ]
        );
    }


    public function store(UserProfileRequest $request)
    {
        $user        = $request->user();
        $userProfile = $user->userProfile()
                            ->updateOrCreate(
                                ['user_id' => $user->id],
                                $request->validated()
                            );

        return new ApiResourceResponse(
            200,
            StatusEnum::OK,
            __("user-profile.created"),
            new UserProfileResource($userProfile)
        );
    }
}
