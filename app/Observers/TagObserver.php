<?php

namespace App\Observers;

use App\Models\Tag;
use Illuminate\Support\Facades\Storage;

class TagObserver
{
    /**
     * Handle the Tag "created" event.
     */
    public function created(Tag $tag): void
    {
        //
    }

    /**
     * Handle the Tag "updated" event.
     */
    public function updated(Tag $tag): void
    {
        if ($tag->isDirty('image')) {
            Storage::disk('private')->delete($tag->getOriginal('image'));
        }
    }

    /**
     * Handle the Tag "deleted" event.
     */
    public function deleted(Tag $tag): void
    {
        if (is_null($tag->image) === false) {
            Storage::disk('private')->delete($tag->getOriginal('image'));
        }
    }

    /**
     * Handle the Tag "restored" event.
     */
    public function restored(Tag $tag): void
    {
        //
    }

    /**
     * Handle the Tag "force deleted" event.
     */
    public function forceDeleted(Tag $tag): void
    {
        //
    }
}
