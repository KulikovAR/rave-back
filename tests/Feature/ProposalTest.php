<?php

namespace Tests\Feature;

use App\Models\Proposal;
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

        $proposal = Proposal::findOrFail($response->json()['data']['id']);
        
        Storage::disk('private')->assertExists($proposal->file);

        $response->assertStatus(200);
    }
}