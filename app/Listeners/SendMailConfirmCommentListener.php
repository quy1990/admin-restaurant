<?php

namespace App\Listeners;

use App\Events\CommentEvent;
use App\Jobs\SendConfirmInvitationJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailConfirmCommentListener implements ShouldQueue
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
     * @param CommentEvent $event
     * @return void
     */
    public function handle(CommentEvent $event)
    {
        //send email to customer, who invited someone
        $comment = $event->comment;
        $details = [
            'title'    => 'You made an Invitation to go a Restaurant',
            'from'     => $comment->user->email,
            'to'       => 10,
            'messages' => $comment->body
        ];

        SendConfirmInvitationJob::dispatch($comment, $details)->delay(now());;
    }
}
