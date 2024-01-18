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
    public function test_not_auth_user_can_not_get_shorts(): void
    {
        $response = $this->json('get', route('short.index'));

        $response->assertStatus(401);
    }

    public function test_show_shorts(): void
    {
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
            $this->getHeadersForUser()
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
        $response = $this->json(
            'get',
            route('short.index'),
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $response->assertJsonStructure($this->getPaginationResponse());
    }

    public function test_increment_view_shorts(): void
    {
        $short=Short::first();
        $shortId=$short->id;
        $oldViews = $short->view_count;
        $response = $this->json(
            'patch',
            route('short.index'),['id'=>$shortId],
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);
        $newViews=Short::find($shortId)->view_count;

        $this->assertSame($oldViews+1,$newViews);
    }
}
