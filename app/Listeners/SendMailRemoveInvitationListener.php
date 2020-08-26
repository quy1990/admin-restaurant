<?php

namespace App\Listeners;

use App\Events\CreateAnInvitationEvent;
use App\Mail\SendInvitationMail;
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
     * @param CreateAnInvitationEvent $customerInviteEvent
     * @return void
     */
    public function handle(CreateAnInvitationEvent $customerInviteEvent)
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
        Mail::to('nguyentuquy2008@gmail.com')->send(new SendInvitationMail($details));
    }
}
