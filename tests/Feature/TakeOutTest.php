<?php

namespace Tests\Feature;

use App\Models\TakeOut;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TakeOutTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_index_history_takeouts(): void
    {
        $response = $this->actingAs($this->getTestUser())->json('get', route('takeout.index'));

        $response->assertStatus(200);

        $this->assertNotEmpty($response->json(['data']));
    }

    public function test_create_takeout_request(): void
    {
        $cardId        = $this->getTestUser()->creditCards->first()->id;
        $totalTakeouts = $this->getTestUser()->creditCards->first()->takeout()->count();

        $requestData = [
            'amount'           => 100,
            'takeoutable_type' => TakeOut::TAKEOUT_CARD,
            'takeoutable_id'   => $cardId
        ];

        $response = $this->actingAs($this->getTestUser())
                         ->json('post', route('takeout.store'), $requestData);

        $response->assertStatus(200);
        $this->assertSame(__('partners.takeout_message_sent'), $response->json('message'));

        $totalTakeoutsResponse = $this->getTestUser()->creditCards->first()->takeout()->count();
        $this->assertGreaterThan($totalTakeouts, $totalTakeoutsResponse);

    }

    public function test_create_takeout_bank_request(): void
    {
        $cardId        = $this->getTestUser()->banks->first()->id;
        $totalTakeouts = $this->getTestUser()->banks->first()->takeout()->count();

        $requestData = [
            'amount'           => 100,
            'takeoutable_type' => TakeOut::TAKEOUT_BANK,
            'takeoutable_id'   => $cardId
        ];

        $response = $this->actingAs($this->getTestUser())
                         ->json('post', route('takeout.store'), $requestData);

        $response->assertStatus(200);
        $this->assertSame(__('partners.takeout_message_sent'), $response->json('message'));

        $totalTakeoutsResponse = $this->getTestUser()->banks->first()->takeout()->count();
        $this->assertGreaterThan($totalTakeouts, $totalTakeoutsResponse);

    }
}
