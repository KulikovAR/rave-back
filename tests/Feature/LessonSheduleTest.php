<?php

namespace Tests\Feature;

use App\Jobs\UserAddLessons;
use App\Models\Lesson;
use App\Models\Setting;
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

        $setting_lesson_shedule_duration = Setting::getValueFromFieldName('lesson_shedule_duration');

        $lesson_shedule_duration = $setting_lesson_shedule_duration ? $setting_lesson_shedule_duration : UserAddLessons::DEFAULT_DURATION;
        
        (new UserAddLessons())->handle();

        $user = $user->fresh();

        $this->assertTrue($user->last_video_added_at != null);
        
        $this->assertTrue($user->lessons()->count() == 1);


        $this->travelTo(Carbon::now()->addMinutes($lesson_shedule_duration + 1));

        (new UserAddLessons())->handle();

        $user = $user->fresh();

        $this->assertTrue($user->lessons()->count() == 2);
    }   


    public function test_add_new_lesson_if_schedule_empty() {
        $user = $this->createTestUserWithSubscription();

        $lessons = Lesson::all();

        foreach($lessons as $lesson) {
            $user->lessons()->attach($lesson);
        }

        $lesson = Lesson::factory()->create();

        $user->addNewLessonIfScheduleEmpty();

        $this->assertTrue($user->lessons()->count() == Lesson::count());
    }
}
