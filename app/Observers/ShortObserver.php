<?php

namespace App\Observers;

use App\Models\Short;
use Illuminate\Support\Facades\Storage;

class ShortObserver
{
    /**
     * Handle the Short "created" event.
     */
    public function created(Short $short): void
    {
        //
    }

    /**
     * Handle the Short "updated" event.
     */
    public function updated(Short $Short): void
    {
        if ($Short->isDirty('video_path')) {
            Storage::disk('private')->delete('video/' . $Short->getOriginal('video_path'));
        }
    }

    /**
     * Handle the Short "deleted" event.
     */
    public function deleted(Short $Short): void
    {
        if (is_null($Short->video_path) === false) {
            Storage::disk('private')->delete('video/' . $Short->getOriginal('video_path'));
        }
    }

    /**
     * Handle the Short "restored" event.
     */
    public function restored(Short $short): void
    {
        //
    }

    /**
     * Handle the Short "force deleted" event.
     */
    public function forceDeleted(Short $short): void
    {
        //
    }
}
