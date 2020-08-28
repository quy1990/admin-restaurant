<?php
namespace App\Observers;

use App\Traits\ObserverTrait;
use App\Events\ReservationEvent;

class ReservationObserver
{
    use ObserverTrait;

    public $event;

    public function __construct()
    {
        $this->event = new ReservationEvent();
    }
}
