<?php
namespace App\Observers;

use App\Traits\ObserverTrait;
use App\Events\PeopleEvent;

class PeopleObserver
{
    use ObserverTrait;

    public $event;

    public function __construct()
    {
        $this->event = new PeopleEvent();
    }
}
