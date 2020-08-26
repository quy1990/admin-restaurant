<?php

namespace App\Events;

use App\Models\People;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateAPeopleEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $people;

    /**
     * Create a new event instance.
     *
     * @param People $people
     * @return void
     *
     */
    public function __construct(People $people)
    {
        $this->people = $people;
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
