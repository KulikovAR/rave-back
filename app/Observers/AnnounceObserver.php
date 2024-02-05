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
        $this->checkForOnlyOneMainAnnounce($announce);
    }

    /**
     * Handle the Announce "updated" event.
     */
    public function updated(Announce $announce): void
    {
        $this->checkForOnlyOneMainAnnounce($announce);        

        if ($announce->isDirty('video_path')) {
            Storage::disk('private')->delete('video/' . $announce->getOriginal('video_path'));
        }
    }

    /**
     * Handle the Announce "deleted" event.
     */
    public function deleted(Announce $announce): void
    {
        if (is_null($announce->video_path) === false) {
            Storage::disk('private')->delete('video/' . $announce->getOriginal('video_path'));
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

    private function checkForOnlyOneMainAnnounce(Announce $announce): void {
        if(!empty($announce->main)){
            Announce::where('title','<>',$announce->title)->update(['main'=>0]);
        }
    }
}
