<?php

namespace App\Jobs;

use App\Models\Lesson;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserAddLessons implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const DEFAULT_DURATION = 7;
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $setting_lesson_shedule_duration = Setting::getValueFromFieldName('lesson_shedule_duration');

        $lesson_shedule_duration = $setting_lesson_shedule_duration ? $setting_lesson_shedule_duration : self::DEFAULT_DURATION;

        $users = User::where('last_video_added_at', '<', Carbon::now()->subMinutes($lesson_shedule_duration))
            ->orWhere('last_video_added_at', null)
            ->get();

        foreach ($users as $user) {
            $user->addSheduleLesson();
        }

        $users = User::all();

        foreach ($users as $user) {
            $user->addNewLessonIfScheduleEmpty();
        }
    }
}