<?php

namespace App\Listeners;

use App\Events\customerOrder;
use App\Events\CustomerReserveEvent;
use App\Mail\SubmitOrderMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

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
     * @param CustomerReserveEvent $customerReserveEvent
     * @return void
     */
    public function handle(CustomerReserveEvent $customerReserveEvent)
    {
        mail("nguyentuquy2008@gmail.com","My subject", "messages");
//
//        $owners = $customerReserveEvent->reservation->restaurant()->owners();
//        foreach ($owners as $owner) {
//            Mail::to("nguyentuquy2008@gmail.com")->send("sended mail");
//        }

    }
}
