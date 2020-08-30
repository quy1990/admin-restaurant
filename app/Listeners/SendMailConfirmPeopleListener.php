<?php

namespace App\Listeners;


use App\Events\PeopleEvent;
use App\Jobs\SendConfirmPeopleJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailConfirmPeopleListener implements ShouldQueue
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
     * @param PeopleEvent $peopleEvent
     * @return void
     */
    public function handle(PeopleEvent $peopleEvent)
    {
        $details = [
            'title'    => 'You made an Invitation to go a Restaurant',
            'from'     => $peopleEvent->people->user->email,
            'to'       => 10,
            'messages' => $peopleEvent->people->invitation->message
        ];

        SendConfirmPeopleJob::dispatch($peopleEvent->people, $details)->delay(now());;
    }
}
