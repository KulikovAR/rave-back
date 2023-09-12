<?php

namespace Tests\Feature;

use App\Jobs\UserAddLessons;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class LessonSheduleTest extends TestCase
{
    public function testUserAddLessonJob()
    {
        $user = $this->createTestUserWithSubscription();

        (new UserAddLessons())->handle();

        $user = $user->fresh();

        $this->assertTrue($user->last_video_added_at != null);
        
        $this->assertTrue($user->lessons()->count() == 1);


        $this->travelTo(Carbon::now()->addDays(8));

        (new UserAddLessons())->handle();

        $user = $user->fresh();

        $this->assertTrue($user->lessons()->count() == 2);
    }   
}
