<?php

namespace App\Listeners;

use App\Events\PartnerMessageEvent;
use App\Notifications\PartnerMessageNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PartnerMessageListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PartnerMessageEvent $event): void
    {
        $partnerMessageModel = $event->partnerMsg;

        $partnerMessageModel->approved = true;
        $partnerMessageModel->save();

        $partnerMessageModel->user()->update(['is_partner' => true]);

        $partnerMessageModel->user->notify(new PartnerMessageNotification());
    }
}
