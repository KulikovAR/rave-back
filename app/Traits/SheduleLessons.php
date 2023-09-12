<?php

namespace App\Traits;

use App\Models\Lesson;

trait SheduleLessons
{
    public function addSheduleLesson()
    {
        $lesson_order = $this->lessons()->count();

        if ($lesson_order < $this->available_lessons_count) {
            $lesson = Lesson::orderBy('order_in_display', 'asc')->skip($lesson_order)->take(1)->get()->first();

            $this->lessons()->sync($lesson);

            $this->update([
                'last_video_added_at' => now()
            ]);
        }
    }
}