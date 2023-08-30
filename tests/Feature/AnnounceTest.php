<?php

namespace Tests\Feature;

use App\Http\Resources\Announce\AnnounceResource;
use App\Models\Announce;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AnnounceTest extends TestCase
{
    public function test_not_auth(): void
    {
        $response = $this->json('get', route('announce.index'));

        $response->assertStatus(401);
    }

    public function test_view(): void
    {
        $announce = Announce::factory()->create();

        $response = $this->json(
            'get',
            route('announce.index'),
            [
                'id' => $announce->id
            ],
            $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'message',
            'status',
            'data'
        ]);

        $this->assertSameResource(new AnnounceResource($announce), $response->json('data'));
    }

    public function test_index(): void
    {
        $response = $this->json(
            'get',
            route('announce.index'),
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $response->assertJsonStructure($this->getPaginationResponse());
    }
}
