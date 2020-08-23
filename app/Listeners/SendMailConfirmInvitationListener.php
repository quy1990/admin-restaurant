<?php

namespace App\Listeners;

use App\Events\CustomerInviteEvent;
use App\Events\customerOrder;
use App\Mail\Mailer;
use App\Mail\SendConfirmMail;
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
        $peoples = $customerInviteEvent->invitation->peoples();
        foreach ($peoples as $people){
            $details = [
                'title' => 'You were invited in a Restaurant',
                'from' => $people->user()->email,
                'to' => $people->email??$people->phone,
                'messages' => $people->messages
            ];

            Mail::to('nguyentuquy2008@gmail.com')->send(new SendConfirmMail($details));
        }
    }
}
