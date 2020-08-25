<?php

namespace App\Models\ModelObservers;

use App\Events\CustomerReservedEvent;
use App\Models\Reservation;

class ReservationObserver
{
    /**
     * Hook into user deleting event.
     *
     * @param Reservation $reservation
     * @return void
     */
    public function deleting(Reservation $reservation)
    {

    }

    public function created(Reservation $reservation)
    {
        event(new CustomerReservedEvent($reservation));
    }

    public function restoring(Reservation $reservation)
    {
        //
    }
}
