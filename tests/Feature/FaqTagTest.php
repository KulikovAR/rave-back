<?php

namespace Tests\Feature;

use App\Models\FaqTag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FaqTagTest extends TestCase
{
    public function test_index(): void
    {
        $response = $this->json(
            'get',
            route('faq_tag.index'),
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $response->assertJsonStructure(
            $this->getPaginationResponse(
                data: [
                    [
                        'name',
                    ]
                ]
            )
        );
    }

    public function test_get_faq_tag_with_faqs_by_faq_tag_id(): void
    {
        $faq_tag = FaqTag::first();


        $response = $this->json(
            'get',
            route('faq_tag.show', ['id' => $faq_tag->id]),
            headers: $this->getHeadersForUser()
        );

        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'message',
                'status',
                'data' => [
                    'name',
                    'faqs' => $this->getPaginationResponse()
                ]
            ]
        );

    }
}