<?php

namespace App\Events;
use App\Models\People;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PeopleEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $people, $action;

    public function __construct()
    {

    }

    /**
     * @param People $people
     * @param int $action
     * @return PeopleEvent
     */
    public function setParams(People $people, int $action)
    {
        $this->people = $people;
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
