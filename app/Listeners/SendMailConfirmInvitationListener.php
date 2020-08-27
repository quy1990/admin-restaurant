<?php

namespace App\Listeners;

use App\Events\Created\CreateAnInvitationEvent;
use App\Jobs\SendConfirmInvitationJob;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     * @param CreateAnInvitationEvent $customerInviteEvent
     * @return void
     */
    public function handle(CreateAnInvitationEvent $customerInviteEvent)
    {
        //send email to customer, who invited someone
        $invitation = $customerInviteEvent->invitation;
        $details = [
            'title'    => 'You made an Invitation to go a Restaurant',
            'from'     => $invitation->user->email,
            'to'       => 10,
            'messages' => $invitation->message
        ];

        SendConfirmInvitationJob::dispatch($invitation, $details)->delay(now());;
    }
}
