<?php

namespace Tests\Feature;

use App\Http\Resources\Shorts\ShortResource;
use App\Models\Short;
use App\Models\User;
use Carbon\Carbon;
use Database\Factories\SlideFactory;
use Tests\TestCase;

class ShortsTest extends TestCase
{
    public function test_not_auth(): void
    {
        $response = $this->json('get', route('short.index'));

        $response->assertStatus(401);
    }

    public function test_auth(): void
    {
        $user = User::factory()->create([
            'subscription_expires_at' => Carbon::now()->addMonths(5)
        ]);

        $response = $this->json('get', route('short.index'), headers: $this->getHeadersForUser($user));

        $response->assertStatus(200);
    }

    public function test_view(): void
    {
        $user = User::factory()->create([
            'subscription_expires_at' => Carbon::now()->addMonths(5)
        ]);

        $shorts = Short::factory()->count(20)->create();

        foreach ($shorts as $short) {
            $short->slides()->create((new SlideFactory())->definition());
        }

        $response = $this->json(
            'get',
            route('short.index'),
            [
                'id' => $short->id
            ],
            $this->getHeadersForUser($user)
        );

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'message',
            'status',
            'data'
        ]);

        $this->assertSameResource(new ShortResource($short), $response->json('data'));
    }

    public function test_index(): void
    {
        $user = User::factory()->create([
            'subscription_expires_at' => Carbon::now()->addMonths(5)
        ]);

        $response = $this->json(
            'get',
            route('short.index'),
            headers: $this->getHeadersForUser($user)
        );

        $response->assertStatus(200);

        $response->assertJsonStructure($this->getPaginationResponse());
    }
}
