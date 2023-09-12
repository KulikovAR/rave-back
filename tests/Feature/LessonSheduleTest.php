<?php

namespace Tests\Feature;

use App\Jobs\UserAddLessons;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class LessonSheduleTest extends TestCase
{
    public function testUserAddLessonJob()
    {
        // Queue::fake();

        // UserAddLessons::dispatch();

        // Queue::assertPushed(UserAddLesson::class);

        // $this->travelTo(Carbon::now()->addDays(8));

        // Queue::assertPushed(UserAddLesson::class);

        // $this->travelTo(Carbon::now()->addDays(16));

        // Queue::assertPushed(UserAddLesson::class);

    }
}
