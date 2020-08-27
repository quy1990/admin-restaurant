<?php

namespace App\Listeners;


use App\Events\Created\CreateAPeopleEvent;
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
     * @param CreateAPeopleEvent $createAPeopleEvent
     * @return void
     */
    public function handle(CreateAPeopleEvent $createAPeopleEvent)
    {
        $details = [
            'title'    => 'You made an Invitation to go a Restaurant',
            'from'     => $createAPeopleEvent->people->user->email,
            'to'       => 10,
            'messages' => $createAPeopleEvent->people->invitation->message
        ];

        SendConfirmPeopleJob::dispatch($createAPeopleEvent->people, $details)->delay(now());;
    }
}
