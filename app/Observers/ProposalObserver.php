<?php

namespace App\Observers;

use App\Models\Proposal;
use Illuminate\Support\Facades\Storage;

class ProposalObserver
{
    /**
     * Handle the Proposal "created" event.
     */
    public function created(Proposal $proposal): void
    {
        //
    }

    /**
     * Handle the Proposal "updated" event.
     */
    public function updated(Proposal $proposal): void
    {
        if ($proposal->isDirty('image')) {
            Storage::disk('private')->delete($proposal->getOriginal('image'));
        }
    }

    /**
     * Handle the Proposal "deleted" event.
     */
    public function deleted(Proposal $proposal): void
    {
        if (is_null($proposal->image) === false) {
            Storage::disk('private')->delete($proposal->getOriginal('image'));
        }
    }

    /**
     * Handle the Proposal "restored" event.
     */
    public function restored(Proposal $proposal): void
    {
        //
    }

    /**
     * Handle the Proposal "force deleted" event.
     */
    public function forceDeleted(Proposal $proposal): void
    {
        //
    }
}
