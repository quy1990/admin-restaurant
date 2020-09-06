<?php

namespace App\Listeners;

use App\Events\InvitationEvent;
use App\Jobs\InvitationJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class InvitationListener implements ShouldQueue
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
     * @param InvitationEvent $event
     * @return void
     */
    public function handle(InvitationEvent $event)
    {
        //send email to customer, who invited someone
        $invitation = $event->invitation;
        $details = [
            'title'    => 'You made an Invitation to go a Restaurant',
            'from'     => $invitation->user->email,
            'to'       => 10,
            'messages' => $invitation->message
        ];

        InvitationJob::dispatch($invitation, $details)->delay(now());;
    }
}
