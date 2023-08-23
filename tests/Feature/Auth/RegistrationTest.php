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
    public function test_registration(): void
    {
        Notification::fake();

        $pass      = $this->faker->password(8, 10);
        $email     = $this->faker->email;
        $firstname = $this->faker->text(10);
        $lastname  = $this->faker->text(10);

        $response = $this->json('post', route('registration'), [
            'email'                 => $email,
            'accept_terms'          => 1,
            'password'              => $pass,
            'password_confirmation' => $pass,
            'firstname'             => $firstname,
            'lastname'              => $lastname
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'message',
            'data' => ['user', 'token']
        ]);

        $this->assertSame(__('registration.verify_email'), $response->json(['message']));

        $this->assertNotEmpty($response->json(['data'])['token']);

        $this->assertAuthenticated('sanctum'); // ='web'
    }


    public function test_user_registration_validation(): void
    {
        $response = $this->json('post', route('registration'), [
            'email'                 => 'bad_email',
            'accept_terms'          => 0,
            'password'              => 'small',
            'password_confirmation' => 'not_same',
            'firstname'             => null,
            'lastname'              => null
        ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'message',
            'errors' => ['email', 'password', 'firstname', 'lastname']
        ]);

        $this->assertGuest();
    }





}