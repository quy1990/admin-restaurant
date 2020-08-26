<?php

namespace App\Listeners;

use App\Events\CreateAReservationEvent;
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
     * @param CreateAReservationEvent $customerReserveEvent
     * @return void
     */
    public function handle(CreateAReservationEvent $customerReserveEvent)
    {
        //mail("nguyentuquy2008@gmail.com", "My subject", "messages");
    }
}
