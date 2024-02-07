<?php

namespace App\Traits;

use App\Models\Lesson;

trait SheduleLessons
{
    public function addSheduleLesson()
    {   
        if(!$this->subscriptionAvailable()) {
            return;
        }

        $lesson_order = $this->lessons()->count();

        $lesson = Lesson::orderBy('order_in_display', 'asc')->skip($lesson_order)->take(1)->get()->first();

        $this->lessons()->attach($lesson);

        $this->update([
            'last_video_added_at' => now()
        ]);
    }

    public function addNewLessonIfScheduleEmpty()
    {
        if (!$this->subscriptionAvailable()) {
            return;
        }

        $lesson_order = $this->lessons()->count();

        if($lesson_order < Lesson::count() - 1) {
            return;
        }

        $lesson = Lesson::orderBy('order_in_display', 'asc')->skip($lesson_order)->take(1)->get()->first();

        $this->lessons()->attach($lesson);

        $this->update([
            'last_video_added_at' => now()
        ]);
    }
}