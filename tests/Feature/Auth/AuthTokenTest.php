<?php

namespace Tests\Feature\Auth;

use App\Http\Resources\UserResource;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Tests\TestCase;

class AuthTokenTest extends TestCase
{
    public function test_login_and_api_token_created(): void
    {
        $user = $this->getTestUser();

        $response = $this->json('post', route('login.stateless'), [
            'email'    => $user->email,
            'password' => UserSeeder::USER_PASSWORD,
        ],
        [
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/116.0.0.0 Safari/537.36'
        ]
        );

        $response->assertStatus(200);
  
        $response->assertJsonStructure([
                                           'status',
                                           'message',
                                           'data' => ['user', 'token']
                                       ]);

        $this->assertNotEmpty($response->json(['data'])['token']);

        $this->assertSameResource(new UserResource($user), $response->json(['data'])['user']);
    }

    public function test_login_email_validation(): void
    {
        $response = $this->json('post', route('login.stateless'), [
            'email'    => 'bad email',
            'password' => 'password',
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
            'email'    => $this->getTestUser()->email,
            'password' => "bad_pass",
        ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
                                           'message',
                                           'errors' => ['password']
                                       ]);
    }

    public function test_logout_and_api_token_removed(): void
    {
        $user = $this->getTestUser();
        $user->tokens()->delete();

        $response = $this->json(
                     'delete',
                     route('logout.stateless'),
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $response->assertJsonStructure([
                                           'message',
                                           'status',
                                           'data'
                                       ]);

        $this->assertEmpty($user->tokens()->get());
    }

    public function test_access_to_protected_routes(): void
    {
        $response = $this->json('delete', route('logout.stateless'));

        $response->assertStatus(401);
    }
}
