<?php

namespace App\Traits;

use App\Models\Lesson;
use Carbon\Carbon;

trait Orderable
{
    public static function recount(): void {
        $lessons = Lesson::orderBy('order_in_display')->get();
        $count = 0;

        foreach($lessons as $lesson) {
            $lesson->order_in_display = $count;
            $lesson->save();
            $count++;
        }
        return;
    }
}

