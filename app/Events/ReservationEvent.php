<?php

namespace App\Events;

use App\Models\Reservation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReservationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $reservation, $action;

    public function __construct()
    {

    }

    /**
     * @param Reservation $reservation
     * @param int $action
     * @return ReservationEvent
     */
    public function setParams(Reservation $reservation, int $action)
    {
        $this->reservation = $reservation;
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
