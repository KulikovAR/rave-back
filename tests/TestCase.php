<?php

namespace Tests;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public \Faker\Generator $faker;

    public array $userBearerHeaders;

    public function __construct(string $name)
    {
        parent::__construct($name);
        $this->faker = \Faker\Factory::create();
    }

    protected function setup(): void
    {

        parent::setUp();
        Cache::flush();

        $this->userBearerHeaders = $this->getHeadersForUser();

        //$this->artisan('migrate:fresh');
        //$this->seed(DatabaseSeeder::class);
    }

    protected function getTestUser(): User
    {
        return User::where(["email" => UserSeeder::USER_EMAIL])->firstOrFail();
    }

    protected function getHeadersForUser(User $user = null): array
    {
        $token = ($user ?? $this->getTestUser())
            ->createToken('spa')
            ->plainTextToken;

        return ['Authorization' => "Bearer $token"];
    }

    protected function assertSameResource(JsonResource $resource, array $responseArray): void
    {
        $this->assertSame(json_decode($resource->toJson(), true), $responseArray);
    }

    protected function assertNotSameResource(JsonResource $resource, array $responseArray): void
    {
        $this->assertNotSame(json_decode($resource->toJson(), true), $responseArray);
    }
}
