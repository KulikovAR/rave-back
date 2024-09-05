<?php

namespace App\Http\Controllers;


use App\Enums\StatusEnum;
use App\Http\Requests\UserProfile\UserProfileRequest;
use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiJsonResponse;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{

    public function index(Request $request)
    {
        return new ApiJsonResponse(
            data: new UserResource($request->user())
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

        return new ApiJsonResponse(
            200,
            StatusEnum::OK,
            __("user-profile.created"),
            new UserProfileResource($userProfile)
        );
    }
}
