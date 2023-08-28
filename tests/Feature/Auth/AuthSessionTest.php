<?php

namespace Feature\Auth;

use App\Http\Resources\UserResource;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Tests\TestCase;

class AuthSessionTest extends TestCase
{
    public function test_login(): void
    {
        $user = $this->getTestUser();

        $user->tokens()->delete();

        $response = $this->postJson(route('login.stateful'), [
            'email'    => $user->email,
            'password' => UserSeeder::USER_PASSWORD
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
                                           'message',
                                           'status',
                                           'data'
                                       ]);

        $this->assertAuthenticated('web');

        $this->assertEmpty($user->tokens()->get());
    }

    public function test_stateful_logout(): void
    {
        $user = $this->getTestUser();

        $response = $this->json('post', route('login.stateful'), [
            'email'    => $user->email,
            'password' => UserSeeder::USER_PASSWORD,
        ]);
        $response->assertStatus(200);

        $response = $this->json('delete', route('logout.stateful'));
        $response->assertStatus(200);

        $response->assertJsonStructure([
                                           'message',
                                           'status',
                                           'data'
                                       ]);

        $this->assertGuest('web');
    }

    public function test_access_to_protected_routes(): void
    {
        $response = $this->json('post', route('login.stateful'), [
            'email'    => $this->getTestUser()->email,
            'password' => UserSeeder::USER_PASSWORD,
        ]);
        $response->assertStatus(200);

        $response = $this->json('patch', route('password.update'), [
            'current_password'      => UserSeeder::USER_PASSWORD,
            'password'              => UserSeeder::USER_PASSWORD,
            'password_confirmation' => UserSeeder::USER_PASSWORD,
        ]);

        $response->assertStatus(200);

        $this->assertAuthenticated('web');
    }
}
