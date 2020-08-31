<?php

namespace App\Events;

use App\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment, $action;

    public function __construct()
    {

    }

    /**
     * @param Comment $comment
     * @param int $action
     * @return CommentEvent
     */
    public function setParams(Comment $comment, int $action)
    {
        $this->comment = $comment;
        $this->action = $action;
        return $this;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
