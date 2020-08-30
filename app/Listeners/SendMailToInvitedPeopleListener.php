<?php

namespace App\Listeners;


use App\Events\PeopleEvent;
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
     * @param PeopleEvent $event
     * @return void
     */
    public function handle(PeopleEvent $event)
    {
        $details = [
            'title'    => 'You were invited to go a Restaurant',
            'from'     => $event->people->user->email,
            'to'       => $event->people->email ?? $event->people->phone,
            'messages' => $event->people->invitation->message
        ];
        Mail::to($event->people->email)->send(new SendInvitationMail($details));
    }
}
