<?php

namespace Tests\Feature\Controllers;

use App\Models\Restaurant;
use App\Models\ServiceSchedule;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ServiceScheduleApiTest extends TestCase
{
    use DatabaseTransactions;

    public function test_get_service_schedule()
    {
        $restaurant = Restaurant::factory()->create();

        $response = $this->getJson("/api/v1/service_schedule/{$restaurant->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    '*' => ['day_of_week', 'is_open', 'opening_time', 'closing_time'],
                ],
            ]);
    }

    public function test_update_service_schedule()
    {
        $restaurant = Restaurant::factory()->create();
        $schedule = ServiceSchedule::where([
            'restaurant_id' => $restaurant->id,
            'day_of_week' => 'Monday',
        ])->first();

        $response = $this->putJson("/api/v1/service_schedule/{$schedule->id}", [
            'is_open' => false,
            'opening_time' => '09:00',
            'closing_time' => '18:00',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Расписание обновлено успешно.',
                'data' => [
                    'day_of_week' => 'Monday',
                    'is_open' => false,
                    'opening_time' => '09:00',
                    'closing_time' => '18:00',
                ],
            ]);
    }
}
