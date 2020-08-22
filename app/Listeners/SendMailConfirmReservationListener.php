<?php

namespace App\Listeners;

use App\Events\customerOrder;
use App\Events\CustomerReserveEvent;
use App\Mail\SubmitOrderMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

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
        $owners = $customerReserveEvent->reservation->restaurant()->owners();
        foreach ($owners as $owner) {
            Log::info("sent mail to ". $owner->email);
            //Mail::to($owner->email)->send("sended mail");
        }

    }
}
