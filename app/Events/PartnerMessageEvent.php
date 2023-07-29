<?php

namespace App\Events;

use App\Models\PartnerMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PartnerMessageEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public PartnerMessage $partnerMsg;

    /**
     * Create a new event instance.
     */
    public function __construct(PartnerMessage $partnerMsg)
    {
        //
        $this->partnerMsg = $partnerMsg;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
