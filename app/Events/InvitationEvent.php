<?php

namespace App\Events;
use App\Models\Invitation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvitationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $invitation, $action;

    public function __construct()
    {

    }

    /**
     * @param Invitation $invitation
     * @param int $action
     * @return InvitationEvent
     */
    public function setParams(Invitation $invitation, int $action)
    {
        $this->invitation = $invitation;
        $this->action = $action;
        return $this;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
