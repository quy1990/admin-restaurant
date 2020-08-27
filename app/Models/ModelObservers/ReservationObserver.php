<?php

namespace App\Models\ModelObservers;

use App\Events\Created\CreateAReservationEvent;
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

    /**
     * @param Reservation $reservation
     */
    public function created(Reservation $reservation)
    {
        event(new CreateAReservationEvent($reservation));
    }


    /**
     * @param Reservation $reservation
     */
    public function update(Reservation $reservation)
    {
        event(new UpdateAReservationEvent($reservation));
    }

    /**
     * @param Reservation $reservation
     */
    public function restoring(Reservation $reservation)
    {
        //
    }
}
