<?php

namespace Feature\Auth;

use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EmailVerifyTest extends TestCase
{
    public function test_verification_send_new_email_saved(): void
    {
        Notification::fake();

        $user = User::factory()->create(['email_verified_at' => null]);

        $newEmail = $this->faker->email;
        $data     = ['email' => $newEmail];

        $response = $this->json(
            'post',
            route('verification.email.send'),
            $data,
            $this->getHeadersForUser($user)
        );

        $response->assertStatus(200);

        Notification::assertSentTo($user, VerifyEmailNotification::class);

        $this->assertSame($newEmail, $user->fresh()->email);
    }

    public function test_verification_not_send_if_email_already_verified(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $data = ['email' => $user->email];

        $response = $this->json(
            'post',
            route('verification.email.send'),
            $data,
            $this->getHeadersForUser($user)
        );

        $response->assertStatus(200);

        Notification::assertNotSentTo($user, VerifyEmailNotification::class);
    }

    public function test_verification_not_send_if_user_with_email_exists(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $data = ['email' => UserSeeder::USER_EMAIL];

        $response = $this->json(
            'post',
            route('verification.email.send'),
            $data,
            $this->getHeadersForUser($user)
        );

        $response->assertStatus(422);

        Notification::assertNotSentTo($user, VerifyEmailNotification::class);
    }

    public function test_email_verification_and_redirect_to_front(): void
    {
        Notification::fake();

        $pass  = $this->faker->password(8, 10);
        $email = $this->faker->email;
        $firstname = $this->faker->text(10);
        $lastname  = $this->faker->text(10);

        $response = $this->json('post', route('registration'), [
            'email'                 => $email,
            'password'              => $pass,
            'password_confirmation' => $pass,
            'firstname'             => $firstname,
            'lastname'              => $lastname
        ]);

        $response->assertStatus(200);

        $user = User::where(['email' => $email])->first();

        $verificationUrl = "";
        Notification::assertSentTo($user, VerifyEmailNotification::class, function ($notification) use ($user, $response, &$verificationUrl) {
            $mailData        = $notification->toMail($user);
            $verificationUrl = $mailData->actionUrl;
            return true;
        });

        $response = $this->get($verificationUrl);
        $response->assertStatus(302);

        $bearerTokenCookie = $response->headers->getCookies()[0];

        $this->assertSame($bearerTokenCookie->getName(), 'bearer_token');
        $this->assertNotEmpty($bearerTokenCookie->getValue());

        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_email_verification_when_not_auth(): void
    {
        Notification::fake();

        $pass  = $this->faker->password(8, 10);
        $email = $this->faker->email;
        $firstname = $this->faker->text(10);
        $lastname  = $this->faker->text(10);

        $response = $this->json('post', route('registration'), [
            'email'                 => $email,
            'password'              => $pass,
            'password_confirmation' => $pass,
            'firstname'             => $firstname,
            'lastname'              => $lastname
        ]);

        $response->assertStatus(200);

        $user = User::where(['email' => $email])->first();

        $verificationUrl = "";
        Notification::assertSentTo($user, VerifyEmailNotification::class, function ($notification) use ($user, $response, &$verificationUrl) {
            $mailData        = $notification->toMail($user);
            $verificationUrl = $mailData->actionUrl;
            return true;
        });

        $response = $this->json('delete', route('logout.stateful'));
        $response->assertStatus(200);
        $this->assertGuest('web');

        $response = $this->get($verificationUrl);
        $response->assertStatus(302);


        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }
}
