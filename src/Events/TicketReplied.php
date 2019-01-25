<?php

namespace Sdkcodes\LaraTicket\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Sdkcodes\LaraTicket\Models\TicketComment;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TicketReplied
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var Sdkcodes\Models\TicketComment */
    public $comment;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(TicketComment $comment)
    {
        $this->comment = $comment;
        
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
