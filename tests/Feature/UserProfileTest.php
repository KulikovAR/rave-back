<?php

namespace Tests\Feature;

use App\Http\Resources\UserProfileResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Database\Factories\UserProfileFactory;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    public function test_unverified_email_user_cant_store_profile(): void
    {
        $user = User::factory()->create(['email_verified_at' => null]);

        $response = $this->actingAs($user)->json('post', route('user_profile.store'), []);
        $response->assertStatus(403);

    }

    public function test_get_user_profile(): void
    {
        $user = User::factory()->create();
        $user->userProfile()->create((new UserProfileFactory())->definition());

        $response = $this->actingAs($user)
                         ->json('get', route('user_profile.index'));

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'status', 'message', 'data' => ["user" => ['id'], "profile" => ['firstname']]
            ]);
    }

    public function test_store_profile(): void
    {
        $user = User::factory()->create();
        $this->assertCount(0, $user->userProfile()->get());

        $inputData = (new UserProfileFactory())->definitionRequest();

        $response = $this->actingAs($user)
                         ->json('post', route('user_profile.store'), $inputData);

        $response->assertStatus(200);
        $response->assertJsonStructure(['status', 'message', 'data']);

        $this->assertSame(__('user-profile.created'), $response->json('message'));

        $this->assertSameResource(new UserProfileResource($user->userProfile), $response->json('data'));

        $this->assertCount(1, $user->userProfile()->get());
    }

    public function test_store_profile_without_date_expires_field(): void
    {
        $user = User::factory()->create();
        $this->assertCount(0, $user->userProfile()->get());

        $inputData                     = (new UserProfileFactory())->definitionRequest();
        $inputData['document_expires'] = null;
        $inputData['phone_prefix']     = "+1-238";

        $response = $this->actingAs($user)
                         ->json('post', route('user_profile.store'), $inputData);

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
            "phone_prefix"     => "-4",
            "phone"            => 'aswd88989454',
            "country"          => 'gdfg',
            "firstname"        => 'Марина',
            "lastname"         => 'Апыва',
            "birthday"         => '300218882',
            "gender"           => 'none',
            "document_number"  => '',
            "document_expires" => 'asd',
        ];

        $response = $this->actingAs($user)
                         ->json('post', route('user_profile.store'), $inputData);

        $response->assertStatus(422);

        $response->assertJsonStructure(
            [
                'message', 'errors' => [
                "phone_prefix",
                "phone",
                "country",
                "firstname",
                "lastname",
                "birthday",
                'gender',
                "document_number",
                "document_expires",]
            ]);
    }


    public function test_update_profile(): void
    {
        $user        = User::factory()->create();
        $userProfile = $user->userProfile()->create((new UserProfileFactory())->definition());

        $this->assertCount(1, $user->userProfile()->get());

        $inputData = (new UserProfileFactory())->definitionRequest();

        $response = $this->actingAs($user)
                         ->json('post', route('user_profile.store'), $inputData);

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
        $this->assertNotSame($rawUserProfile->document_number, $user->userProfile->document_number);
        $this->assertNotSame($rawUserProfile->document_expires, $user->userProfile->document_expires);
        $this->assertNotSame($rawUserProfile->birthday, $user->userProfile->birthday);
        $this->assertNotSame($rawUserProfile->phone, $user->userProfile->phone);
        $this->assertSame($rawUserProfile->gender, $user->userProfile->gender);
    }

    public function test_birthday_date_formatted(): void
    {
        $user      = User::factory()->create();
        $inputData = (new UserProfileFactory())->definitionRequest();

        $response = $this->actingAs($user)
                         ->json('post', route('user_profile.store'), $inputData);

        $response->assertStatus(200);

        $this->assertSame($response->json('data')['birthday'], $inputData['birthday']);
        $this->assertNotSame($response->json('data')['birthday'], $user->userProfile->birthday);
    }

    public function test_date_validation(): void
    {
        $user      = User::factory()->create();
        $inputData = [
            "phone_prefix"     => "+4",
            "phone"            => '7897978',
            "country"          => 'Rus',
            "firstname"        => 'dddsa',
            "lastname"         => 'fdfdf',
            "birthday"         => '30.10.2050',
            "gender"           => 'male',
            "document_number"  => '12332312',
            "document_expires" => '30.10.2000',
        ];

        $response = $this->actingAs($user)
                         ->json('post', route('user_profile.store'), $inputData);

        $response->assertStatus(422);

        $response->assertJsonStructure(
            [
                'message', 'errors' => [
                "birthday",
                "document_expires"]
            ]);
    }

    public function test_user_profile_is_shown_after_login(): void
    {
        $user = $this->getTestUser();
        $user->userProfile()->create((new UserProfileFactory())->definition());

        $response = $this->post(route('login.stateless'), [
            'email'    => $user->email,
            'password' => UserSeeder::USER_PASSWORD,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
                                           'status',
                                           'message',
                                           'data' => ['user' => ['profile'], 'token']
                                       ]);

        $this->assertSame(json_decode((new UserResource($user))->toJson(), true), $response->json(['data'])['user']);

        $user->userProfile()->delete();
    }

}
