<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProposalTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_store_proposal(): void
    {
        $response = $this->json(
            'post',
            route('proposal.store'),
            [
                'body' => $this->faker->text(),
                'file' => UploadedFile::fake()->image('test.png')
            ],
            $this->getHeadersForUser()
        );
        
        Storage::disk('public')->assertExists($response->json()['data']['file']);

        $response->assertStatus(200);
    }
}