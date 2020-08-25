<?php

namespace App\Listeners;

use App\Events\CustomerInvitedEvent;
use App\Mail\SendConfirmMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendMailRemoveInvitationListener implements ShouldQueue
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
     * @param CustomerInvitedEvent $customerInviteEvent
     * @return void
     */
    public function handle(CustomerInvitedEvent $customerInviteEvent)
    {
        $peoples = $customerInviteEvent->invitation->peoples();
        foreach ($peoples as $people) {
            $details = [
                'title'    => 'You were invited in a Restaurant',
                'from'     => $people->user()->email,
                'to'       => $people->email ?? $people->phone,
                'messages' => $people->messages
            ];
        }
        Mail::to('nguyentuquy2008@gmail.com')->send(new SendConfirmMail($details));
    }
}
