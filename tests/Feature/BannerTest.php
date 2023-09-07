<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Banner;

class BannerTest extends TestCase
{
    public function test_index(): void
    {
        $response = $this->json(
            'get',
            route('banner.index'),
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $response->assertJsonStructure($this->getPaginationResponse());
    }

    public function test_get_img_by_action_url(): void
    {
        $banner = Banner::factory()->create();

        $response = $this->json(
            'get',
            route('banner.index', ['action_url' => $banner->action_url]),
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'message',
            'data',
        ]);
    }
}
