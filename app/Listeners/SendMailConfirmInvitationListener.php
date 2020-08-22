<?php

namespace App\Listeners;

use App\Events\CustomerInviteEvent;
use App\Events\customerOrder;
use App\Mail\Mailer;
use App\Mail\SubmitOrderMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendMailConfirmInvitationListener implements ShouldQueue
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
     * @param CustomerInviteEvent $customerInviteEvent
     * @return void
     */
    public function handle(CustomerInviteEvent $customerInviteEvent)
    {
        mail("nguyentuquy2008@gmail.com","My subject", "messages");

//        $owners = $customerReserveEvent->reservation->restaurant()->owners();
//        foreach ($owners as $owner) {
//            Mail::to("nguyentuquy2008@gmail.com")->send("sended mail");
//        }

    }
}
