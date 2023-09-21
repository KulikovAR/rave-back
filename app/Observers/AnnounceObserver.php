<?php

namespace App\Observers;

use App\Models\Announce;
use Illuminate\Support\Facades\Storage;

class AnnounceObserver
{
    /**
     * Handle the Announce "created" event.
     */
    public function created(Announce $announce): void
    {
        //
    }

    /**
     * Handle the Announce "updated" event.
     */
    public function updated(Announce $Announce): void
    {
        if ($Announce->isDirty('video_path')) {
            Storage::disk('private')->delete('video/' . $Announce->getOriginal('video_path'));
        }
    }

    /**
     * Handle the Announce "deleted" event.
     */
    public function deleted(Announce $Announce): void
    {
        if (is_null($Announce->video_path) === false) {
            Storage::disk('private')->delete('video/' . $Announce->getOriginal('video_path'));
        }
    }

    /**
     * Handle the Announce "restored" event.
     */
    public function restored(Announce $announce): void
    {
        //
    }

    /**
     * Handle the Announce "force deleted" event.
     */
    public function forceDeleted(Announce $announce): void
    {
        //
    }
}
