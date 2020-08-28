<?php

namespace App\Listeners;


use App\Events\ReservationEvent;
use App\Jobs\SendConfirmReservationJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailConfirmReservationListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param ReservationEvent $event
     * @return void
     */
    public function handle(ReservationEvent $event)
    {
        $details = [
            'title'    => 'Your Restaurant have a new Reservation',
            'from'     => $event->reservation->user->email,
            'to'       => 10,
            'messages' => "Your Restaurant have a new Reservation"
        ];
        SendConfirmReservationJob::dispatch($event->reservation, $details)->delay(now());
    }
}
