<?php

namespace Tests\Feature;

use Tests\TestCase;

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
        $response = $this->json(
            'get',
            route('banner.index', ['action_url' => 'officia-iure-reiciendis-expedita-illum']),
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
