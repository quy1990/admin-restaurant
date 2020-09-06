<?php

namespace App\Listeners;

use App\Events\CommentEvent;
use App\Jobs\CommentJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentListener implements ShouldQueue
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

        CommentJob::dispatch($comment, $details)->delay(now());;
    }
}
