<?php

namespace Tests\Feature;

use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserProfile;
use Database\Factories\UserProfileFactory;
use Database\Seeders\UserSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    public function test_unverified_email_user_cant_store_profile(): void
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $response = $this->json(
            'post',
            route('user_profile.store'),
            headers: $this->getHeadersForUser($user)
        );

        $response->assertStatus(403);
    }

    public function test_get_user_profile(): void
    {
        $user = User::factory()
            ->has(UserProfile::factory(), 'userProfile')
            ->create();

        $response = $this->json(
            'get',
            route('user_profile.index'),
            headers: $this->getHeadersForUser($user)
        );

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'status',
                'message',
                'data' => ['id', "profile" => ['firstname']]
            ]
        );
    }
    public function test_store_avatar_user_profile(): void
    {
        $user     = User::factory()
            ->has(UserProfile::factory(), 'userProfile')
            ->create();

        $response = $this->json(
            'post',
            route('user_profile.store.avatar'),
            [
                'avatar' => UploadedFile::fake()->image('test.png')
            ],
            $this->getHeadersForUser($user)
        );
    
        Storage::disk('public')->assertExists($user->userProfile->avatar);

        $response->assertStatus(200);
    }

    public function test_store_profile(): void
    {
        $user = User::factory()->create();

        $inputData = (new UserProfileFactory())->definitionRequest();

        $response = $this->json(
            'post',
            route('user_profile.store'),
            $inputData,
            $this->getHeadersForUser($user)
        );

        $response->assertStatus(200);

        $response->assertJsonStructure(['status', 'message', 'data']);

        $this->assertSame(__('user-profile.created'), $response->json('message'));

        $this->assertSameResource(new UserProfileResource($user->userProfile), $response->json('data'));

        $this->assertCount(1, $user->userProfile()->get());
    }

    public function test_store_profile_validation(): void
    {
        $user = User::factory()->create();

        $inputData = [
            "firstname" => 1,
            "lastname"  => null,
        ];
        $response  = $this->json(
            'post',
            route('user_profile.store'),
            $inputData,
            $this->getHeadersForUser($user)
        );

        $response->assertStatus(422);

        $response->assertJsonStructure(
            [
                'message',
                'errors' => [
                    "firstname",
                    "lastname",
                ]
            ]
        );
    }

    public function test_update_profile(): void
    {
        $user        = User::factory()->create();
        $userProfile = $user->userProfile()->create((new UserProfileFactory())->definition());

        $this->assertCount(1, $user->userProfile()->get());

        $inputData = (new UserProfileFactory())->definitionRequest();

        $response = $this->json(
            'post',
            route('user_profile.store'),
            $inputData,
            $this->getHeadersForUser($user)
        );

        $response->assertStatus(200);

        $this->assertNotSameResource(new UserProfileResource($userProfile), $response->json('data'));

        $this->assertCount(1, $user->userProfile()->get());
    }

    public function test_user_profile_encrypted(): void
    {
        $user = User::factory()->create();
        $user->userProfile()->create((new UserProfileFactory())->definition());

        $rawUserProfile = DB::table('user_profiles')->where(['user_id' => $user->id])->first();

        $this->assertNotSame($rawUserProfile->firstname, $user->userProfile->firstname);
        $this->assertNotSame($rawUserProfile->lastname, $user->userProfile->lastname);
    }

    public function test_user_profile_is_shown_after_login(): void
    {
        $user = $this->getTestUser();

        $user->userProfile()->create((new UserProfileFactory())->definition());

        $response = $this->json(
            'post',
            route('login.stateless'),
            [
                'email'    => $user->email,
                'password' => UserSeeder::USER_PASSWORD,
            ]
        );

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message',
            'data' => ['user' => ['profile'], 'token']
        ]);

        $this->assertSameResource(new UserResource($user), $response->json(['data'])['user']);

        $user->userProfile()->delete();
    }
}