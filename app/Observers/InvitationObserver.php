<?php
namespace App\Observers;

use App\Traits\ObserverTrait;
use App\Events\InvitationEvent;

class InvitationObserver
{
    use ObserverTrait;

    public $event;

    public function __construct()
    {
        $this->event = new InvitationEvent();
    }
}
