<?php

namespace App\Listeners;

use App\Events\InvitationEvent;
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
     * @param InvitationEvent $event
     * @return void
     */
    public function handle(InvitationEvent $event)
    {
        $peoples = $event->invitation->peoples();
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
