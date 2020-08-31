<?php

namespace App\Observers;

use App\Events\CommentEvent;
use App\Traits\ObserverTrait;

class CommentObserver
{
    use ObserverTrait;

    public $event;

    public function __construct()
    {
        $this->event = new CommentEvent();
    }
}
