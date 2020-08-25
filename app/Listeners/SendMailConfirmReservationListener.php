<?php

namespace App\Listeners;

use App\Events\CustomerReservedEvent;
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
     * @param CustomerReservedEvent $customerReserveEvent
     * @return void
     */
    public function handle(CustomerReservedEvent $customerReserveEvent)
    {
        mail("nguyentuquy2008@gmail.com", "My subject", "messages");
    }
}
