<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FaqTest extends TestCase
{


    public function test_index(): void
    {
        $response = $this->json(
            'get',
            route('faq.index'),
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);


        $response->assertJsonStructure($this->getPaginationResponse(
            data: [
                [
                    'answer',
                    'question',
                    'fag_tag' => [
                        'name'
                    ]
                ]
            ]
        ));
    }
}