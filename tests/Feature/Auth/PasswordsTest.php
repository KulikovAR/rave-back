<?php

namespace Tests\Feature\Auth;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\PasswordResetNotification;
use App\Notifications\VerifyEmailNotification;
use App\Traits\PasswordHash;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordsTest extends TestCase
{
    use PasswordHash;

    public function test_user_can_update_password(): void
    {
        $user           = $this->getTestUser();
        $user->password = $this->hashMake(UserSeeder::USER_PASSWORD);
        $user->save();
        $oldPass = DB::table('users')->where(['email' => UserSeeder::USER_EMAIL])->get('password');

        $response = $this->actingAs($user)->json('patch', route('password.update'), [
            'current_password'      => UserSeeder::USER_PASSWORD,
            'password'              => "password",
            'password_confirmation' => "password",
        ]);

        $newPass = DB::table('users')->where(['email' => UserSeeder::USER_EMAIL])->get('password');
        $this->assertNotSame($oldPass, $newPass);

        $response->assertStatus(200);
        $response->assertJsonStructure([
                                           'status',
                                           'message',
                                           'data'
                                       ]);
        $this->assertSame(__('registration.password_updated'), $response->json(['message']));
    }

    public function test_update_password_validation(): void
    {
        $response = $this->actingAs($this->getTestUser())->json('patch', route('password.update'), [
            'current_password'      => "wrong_pass",
            'password'              => "password",
            'password_confirmation' => "password",
        ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
                                           'message',
                                           'errors' => ['current_password']
                                       ]);
    }

    public function test_send_password_reset_link(): void
    {
        Notification::fake();

        $response = $this->json('post', route('password.send'), [
            'email' => UserSeeder::USER_EMAIL,
        ]);

        $response->assertStatus(200);

        $tokens = DB::table('password_reset_tokens')->where(['email' => UserSeeder::USER_EMAIL])->count();

        $this->assertNotEmpty($tokens);

        Notification::assertSentTo($this->getTestUser(), PasswordResetNotification::class);

        DB::table('password_reset_tokens')->where(['email' => UserSeeder::USER_EMAIL])->delete();
    }

    public function test_send_password_reset_link_validation(): void
    {
        $response = $this->json('post', route('password.send'), [
            'email' => 'bad_email',
        ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
                                           'message',
                                           'errors' => ['email']
                                       ]);
    }

    public function test_reset_password(): void
    {
        $token   = Password::createToken($this->getTestUser());
        $oldPass = DB::table('users')->where(['email' => UserSeeder::USER_EMAIL])->get('password');

        $response = $this->json('post', route('password.reset'), [
            'email'    => UserSeeder::USER_EMAIL,
            'token'    => $token,
            'password' => UserSeeder::USER_PASSWORD,
        ]);

        $response->assertStatus(200);

        $this->assertSame(__('passwords.reset'), $response->json()['message']);

        $newPass = DB::table('users')->where(['email' => UserSeeder::USER_EMAIL])->get('password');
        $this->assertNotSame($oldPass, $newPass);

        $tokensCount = DB::table('password_reset_tokens')->where(['email' => UserSeeder::USER_EMAIL])->count();
        $this->assertEmpty($tokensCount);
    }
}
