<?php

namespace App\Listeners;

use App\Events\CommentEvent;
use App\Jobs\SendConfirmCommentJob;
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
        $comment = $event->comment;
        $details = [
            'title'    => 'You have some comments on your Page',
            'from'     => $comment->user->getFullName(),
            'to'       => 10,
            'messages' => $comment->body
        ];

        SendConfirmCommentJob::dispatch($comment, $details)->delay(now());;
    }
}
