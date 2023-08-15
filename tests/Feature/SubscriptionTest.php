<?php

namespace Tests\Feature;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_have_no_subscription(): void
    {
        $user = User::factory()->hasAttached(Lesson::factory()->create())->create();

        $response = $this->json(
            'get',
            route('lesson.index'),
            headers: $this->getHeadersForUser($user)
        );

        $response->assertStatus(302);

        $response->assertRedirect(config('front-end.subscription_expired'));
    }
}
