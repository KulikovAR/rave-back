<?php

namespace App\Observers;

use App\Models\Slide;
use Illuminate\Support\Facades\Storage;

class SlideObserver
{
    /**
     * Handle the Slide "created" event.
     */
    public function created(Slide $slide): void
    {
        //
    }

    /**
     * Handle the Short "updated" event.
     */
    public function updated(Slide $Slide): void
    {
        if ($Slide->isDirty('video_path')) {
            Storage::disk('public')->delete('video/' . $Slide->getOriginal('video_path'));
        }
    }

    /**
     * Handle the Short "deleted" event.
     */
    public function deleted(Slide $Slide): void
    {
        if (is_null($Slide->video_path) === false) {
            Storage::disk('public')->delete('video/' . $Slide->getOriginal('video_path'));
        }
    }
    /**
     * Handle the Slide "restored" event.
     */
    public function restored(Slide $slide): void
    {
        //
    }

    /**
     * Handle the Slide "force deleted" event.
     */
    public function forceDeleted(Slide $slide): void
    {
        //
    }
}
