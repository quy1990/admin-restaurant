<?php

namespace App\Listeners;

use App\Events\CustomerReserveEvent;
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
     * @param CustomerReserveEvent $customerReserveEvent
     * @return void
     */
    public function handle(CustomerReserveEvent $customerReserveEvent)
    {
        //mail("nguyentuquy2008@gmail.com", "My subject", "messages");
    }
}
