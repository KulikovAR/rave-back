<?php

namespace Tests\Feature\Auth;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function test_user_can_pass_registration(): void
    {
        Notification::fake();

        $pass  = $this->faker->password(8, 10);
        $email = $this->faker->email;

        $response = $this->postJson(route('registration'), [
            'email'                 => $email,
            'accept_terms'          => 1,
            'password'              => $pass,
            'password_confirmation' => $pass,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
                                           'status',
                                           'message',
                                           'data' => ['user']
                                       ]);

        $this->assertSame(__('registration.verify_email'), $response->json(['message']));

        $this->assertAuthenticated('sanctum');
    }

    public function test_verify_notification_sent(): void
    {
        Notification::fake();

        $pass  = $this->faker->password(8, 10);
        $email = $this->faker->email;

        $response = $this->postJson(route('registration'), [
            'email'                 => $email,
            'password'              => $pass,
            'password_confirmation' => $pass,
        ]);

        $response->assertStatus(200);

        $user = User::where(['email' => $email])->first();
        $this->assertEmpty($user->email_verified_at);
        Notification::assertSentTo($user, VerifyEmailNotification::class);
    }

    public function test_user_can_verify_email(): void
    {
        Notification::fake();

        $pass  = $this->faker->password(8, 10);
        $email = $this->faker->email;

        $response = $this->postJson(route('registration'), [
            'email'                 => $email,
            'password'              => $pass,
            'password_confirmation' => $pass,
        ]);

        $response->assertStatus(200);

        $user = User::where(['email' => $email])->first();

        $this->assertAuthenticated('sanctum');

        $actionUrl = "";
        Notification::assertSentTo($user, VerifyEmailNotification::class, function ($notification) use ($user, $response, &$actionUrl) {
            $mailData  = $notification->toMail($user);
            $actionUrl = $mailData->actionUrl;
            return true;
        });

        $response = $this->get($actionUrl);
        $response->assertStatus(302);

        $bearerTokenCookie = $response->headers->getCookies()[0];

        $this->assertSame($bearerTokenCookie->getName(), 'bearer_token');
        $this->assertNotEmpty($bearerTokenCookie->getValue());

        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_user_can_verify_email_after_logout(): void
    {
        Notification::fake();

        $pass  = $this->faker->password(8, 10);
        $email = $this->faker->email;

        $response = $this->postJson(route('registration'), [
            'email'                 => $email,
            'password'              => $pass,
            'password_confirmation' => $pass,
        ]);

        $response->assertStatus(200);

        $user = User::where(['email' => $email])->first();

        $this->assertAuthenticated('sanctum');

        $actionUrl = "";
        Notification::assertSentTo($user, VerifyEmailNotification::class, function ($notification) use ($user, $response, &$actionUrl) {
            $mailData  = $notification->toMail($user);
            $actionUrl = $mailData->actionUrl;
            return true;
        });

        $response = $this->json('delete', route('logout.stateful'));
        $response->assertStatus(200);

        $response = $this->get($actionUrl);
        $response->assertStatus(302);

        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_user_registration_validation(): void
    {
        $response = $this->json('post', route('registration'), [
            'email'                 => 'bad_email',
            'accept_terms'          => 0,
            'password'              => 'small',
            'password_confirmation' => 'not_same',
        ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
                                           'message',
                                           'errors' => ['email', 'password']
                                       ]);

        $this->assertGuest();
    }

    public function test_user_email_verification_send(): void
    {
        Notification::fake();
        $user     = User::factory()->create(['email_verified_at' => null]);
        $data     = ['email' => $user->email];
        $response = $this->actingAs($user)->json('post', route('verification.email.send'), $data);

        $response->assertStatus(200);

        Notification::assertSentTo($user, VerifyEmailNotification::class);
    }

    public function test_verification_send_new_email_saved(): void
    {
        Notification::fake();
        $user     = User::factory()->create(['email_verified_at' => null]);
        $newEmail = $this->faker->email;
        $data     = ['email' => $newEmail];

        $response = $this->actingAs($user)->json('post', route('verification.email.send'), $data);

        $response->assertStatus(200);

        Notification::assertSentTo($user, VerifyEmailNotification::class);

        $this->assertSame($newEmail, $user->email);
    }

    public function test_verification_not_send_if_verified(): void
    {
        Notification::fake();
        $user = User::factory()->create();

        $data = ['email' => $user->email];

        $response = $this->actingAs($user)->json('post', route('verification.email.send'), $data);

        $response->assertStatus(200);

        Notification::assertNotSentTo($user, VerifyEmailNotification::class);
    }

    public function test_verification_not_send_if_user_with_email_exists(): void
    {
        Notification::fake();
        $user = User::factory()->create();

        $data = ['email' => UserSeeder::USER_EMAIL];

        $response = $this->actingAs($user)->json('post', route('verification.email.send'), $data);

        $response->assertStatus(422);

        Notification::assertNotSentTo($user, VerifyEmailNotification::class);
    }
}
