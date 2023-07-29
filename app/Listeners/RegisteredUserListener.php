<?php

namespace App\Listeners;


use App\Events\RegisteredUserEvent;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class RegisteredUserListener
{
    public function handle(RegisteredUserEvent $event): void
    {
        if (
            $event->user instanceof MustVerifyEmail &&
            !$event->user->hasVerifiedEmail()
        ) {
            $event->user->sendEmailVerification();
        }
    }
}
