<?php

namespace App\Http\Controllers\Auth;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailVerifyLinkRequest;
use App\Http\Requests\Auth\SendEmailVerifyRequest;
use App\Http\Responses\ApiJsonResponse;
use App\Traits\BearerTokenTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;

class VerificationContactController extends Controller
{
    use BearerTokenTrait;

    public function sendEmailVerification(SendEmailVerifyRequest $request): ApiJsonResponse
    {
        $user  = $request->user();
        $email = Str::lower($request->email);

        if ($user->hasVerifiedEmail()) {
            return new ApiJsonResponse(
                200,
                StatusEnum::OK,
                __('registration.contact_verified')
            );
        }

        if ($this->isNewEmail($user, $email)) {
            $user->update(['email' => $email]);
        }

        $user->sendEmailVerification();

        return new ApiJsonResponse(
            200,
            StatusEnum::OK,
            __('registration.verification_sent')
        );
    }


    public function isNewEmail(mixed $user, mixed $email): bool
    {
        return $user->email !== $email;
    }

    /**
     * Mark the authenticated user's email address as verified.
     */
    public function verifyEmail(EmailVerifyLinkRequest $request): Redirector|RedirectResponse
    {
        $user = $request->getUserFromUrl();

        if ($user?->hasVerifiedEmail()) {
            return redirect(config('front-end.email_verified_error'));
        }

        if ($user?->markEmailAsVerified()) {

            $token       = $this->createTemporaryAuthToken($user);
            $cookieToken = $this->createBearerCookie($token);

            return redirect(config('front-end.email_verified') . $token)->withCookie($cookieToken);
        }

        return redirect(config('front-end.email_verified_error'));
    }
}