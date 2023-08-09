<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase
{
    public function test_not_auth(): void
    {
        $response = $this->json('get', route('tag.index'));

        $response->assertStatus(401);
    }

    public function test_auth(): void
    {
        $user = User::factory()->create([
            'subscription_expires_at' => Carbon::now()->addMonths(5)
        ]);

        $response = $this->json('get', route('tag.index'), headers: $this->getHeadersForUser($user));

        $response->assertStatus(200);
    }

    public function test_index(): void
    {
        $user = User::factory()->create([
            'subscription_expires_at' => Carbon::now()->addMonths(5)
        ]);

        $response = $this->json(
            'get',
            route('tag.index'),
            headers: $this->getHeadersForUser($user)
        );

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'message',
            'status',
            'data' => [
                [
                    'name',
                    'image'
                ]
            ]
        ]);
    }
}