<?php

namespace Tests\Feature\Auth;

use App\Http\Resources\UserResource;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_user_can_login_and_get_token_api(): void
    {
        $user = User::where(["email" => UserSeeder::USER_EMAIL])->firstOrFail();

        $response = $this->post(route('login.stateless'), [
            'email'    => $user->email,
            'password' => UserSeeder::USER_PASSWORD,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
                                           'status',
                                           'message',
                                           'data' => ['user', 'token']
                                       ]);
        $this->assertNotEmpty($response->json(['data'])['token']);
        $this->assertSame(json_decode((new UserResource($user))->toJson(), true), $response->json(['data'])['user']);
    }

    public function test_login_email_validation(): void
    {
        $response = $this->json('post', route('login.stateless'), [
            'email'    => 'bad email',
            'password' => UserSeeder::USER_PASSWORD,
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
                                           'message',
                                           'errors' => ['email']
                                       ]);

    }

    public function test_login_password_validation(): void
    {
        $response = $this->json('post', route('login.stateless'), [
            'email'    => UserSeeder::USER_EMAIL,
            'password' => "bad_pass",
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
                                           'message',
                                           'errors' => ['password']
                                       ]);
    }

    public function test_logout_and_api_tokens_removed(): void
    {
        $user = User::where(["email" => UserSeeder::USER_EMAIL])->firstOrFail();

        $response = $this->post(route('login.stateless'), [
            'email'    => $user->email,
            'password' => UserSeeder::USER_PASSWORD,
        ]);

        $response->assertStatus(200);
        $this->assertNotEmpty($user->tokens()->get());

        $response = $this->actingAs($user)->json('delete', route('logout.stateless'));
        $response->assertStatus(200);

        $response->assertJsonStructure([
                                           'message',
                                           'status',
                                           'data'
                                       ]);

        $this->assertEmpty($user->tokens()->get());
    }

    public function test_stateful_login(): void
    {
        $user = User::where(["email" => UserSeeder::USER_EMAIL])->firstOrFail();

        $response = $this->postJson(route('login.stateful'), [
            'email'    => $user->email,
            'password' => UserSeeder::USER_PASSWORD,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
                                           'message',
                                           'status',
                                           'data'
                                       ]);

        $this->assertAuthenticated('web');
    }

    public function test_stateful_login_pass_validation(): void
    {
        $user = User::where(["email" => UserSeeder::USER_EMAIL])->firstOrFail();

        $response = $this->postJson(route('login.stateful'), [
            'email'    => $user->email,
            'password' => 'bad_pass',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
                                           'message',
                                           'errors' => ['password']
                                       ]);

        $this->assertGuest('web');
    }

    public function test_stateful_logout(): void
    {
        $user = User::where(["email" => UserSeeder::USER_EMAIL])->firstOrFail();

        $response = $this->postJson(route('login.stateful'), [
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

    public function test_request_to_api_after_statefull_login(): void
    {
        $user = User::where(["email" => UserSeeder::USER_EMAIL])->firstOrFail();

        $response = $this->postJson(route('login.stateful'), [
            'email'    => $user->email,
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

    public function test_user_cant_access_route_without_login(): void
    {
        $response = $this->json('delete', route('logout.stateless'));

        $response->assertStatus(401);
    }
}
