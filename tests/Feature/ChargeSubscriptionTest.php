<?php

namespace Tests\Feature;

use App\Jobs\ChargeSubscriptionJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChargeSubscriptionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_charge_subscription_job(): void
    {

        $user = User::factory()->create(['subscription_expires_at' => now()->subDay()]);

        (new ChargeSubscriptionJob)->handle();

        $this->assertTrue(true);
    }
}
