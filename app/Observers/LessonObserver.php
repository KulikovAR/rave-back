<?php

namespace App\Observers;

use App\Models\Lesson;
use Illuminate\Support\Facades\Storage;

class LessonObserver
{
    /**
     * Handle the Lesson "created" event.
     */
    public function created(Lesson $Lesson): void
    {
        //
    }

    /**
     * Handle the Lesson "updated" event.
     */
    public function updated(Lesson $Lesson): void
    {
        if ($Lesson->isDirty('video_path')) {
            Storage::disk('public')->delete('video/' . $Lesson->getOriginal('video_path'));
        }
    }

    /**
     * Handle the Lesson "deleted" event.
     */
    public function deleted(Lesson $Lesson): void
    {
        if (is_null($Lesson->video_path) === false) {
            Storage::disk('public')->delete('video/' . $Lesson->getOriginal('video_path'));
        }
    }

    /**
     * Handle the Lesson "restored" event.
     */
    public function restored(Lesson $Lesson): void
    {
        //
    }

    /**
     * Handle the Lesson "force deleted" event.
     */
    public function forceDeleted(Lesson $Lesson): void
    {
        //
    }
}
