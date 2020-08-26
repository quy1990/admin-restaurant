<?php

namespace App\Listeners;

use App\Events\CustomerInvitedPeopleEvent;
use App\Mail\SendInvitationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendMailToInvitedPeopleListener implements ShouldQueue
{
    protected $customerInvitedPeopleEvent;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     * @param CustomerInvitedPeopleEvent $customerInvitedPeopleEvent
     * @return void
     */
    public function handle(CustomerInvitedPeopleEvent $customerInvitedPeopleEvent)
    {
        $details = [
            'title'    => 'You were invited to go a Restaurant',
            'from'     => $customerInvitedPeopleEvent->people->user->email,
            'to'       => $customerInvitedPeopleEvent->people->email ?? $customerInvitedPeopleEvent->people->phone,
            'messages' => $customerInvitedPeopleEvent->people->invitation->message
        ];
        Mail::to($customerInvitedPeopleEvent->people->email)->send(new SendInvitationMail($details));
    }
}
