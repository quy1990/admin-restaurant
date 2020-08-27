<?php

namespace App\Listeners;

use App\Events\Created\CreateAReservationEvent;
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
     * @param CreateAReservationEvent $customerCreateAReservationEvent
     * @return void
     */
    public function handle(CreateAReservationEvent $customerCreateAReservationEvent)
    {
        $customerCreateAReservationEvent->reservation->restaurant();
        $details = [
            'title'    => 'Your Restaurant have a new Reservation',
            'from'     => $customerCreateAReservationEvent->reservation->user->email,
            'to'       => 10,
            'messages' => "Your Restaurant have a new Reservation"
        ];
        SendConfirmReservationJob::dispatch($customerCreateAReservationEvent->reservation, $details)->delay(now());
    }
}
