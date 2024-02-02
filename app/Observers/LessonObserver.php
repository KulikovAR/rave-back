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
        Lesson::recount();
    }

    /**
     * Handle the Lesson "updated" event.
     */
    public function updated(Lesson $Lesson): void
    {
        if ($Lesson->isDirty('video_path')) {
            Storage::disk('private')->delete('video/' . $Lesson->getOriginal('video_path'));
        }
        if ($Lesson->isDirty('order_in_display')) {
            Lesson::recount();
        }
        if ($Lesson->isDirty('preview_path')) {
            Storage::disk('private')->delete($Lesson->getOriginal('preview_path'));
        }
    }

    /**
     * Handle the Lesson "deleted" event.
     */
    public function deleted(Lesson $Lesson): void
    {
        if (is_null($Lesson->video_path) === false) {
            Storage::disk('private')->delete('video/' . $Lesson->getOriginal('video_path'));
        }
        if (is_null($Lesson->preview_path) === false) {
            Storage::disk('private')->delete($Lesson->getOriginal('preview_path'));
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
