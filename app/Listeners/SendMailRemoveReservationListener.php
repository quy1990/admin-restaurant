<?php

namespace App\Listeners;


use App\Events\ReservationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailRemoveReservationListener implements ShouldQueue
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
        //mail("nguyentuquy2008@gmail.com", "My subject", "messages");
    }
}
