<?php

namespace App\Traits;

use App\Action;

trait ObserverTrait
{
//    public function retrieved($object)
//    {
//        event($this->event->setParams($object, Action::RETRIEVED));
//    }

//    public function creating(Reservation $object)
//    {
//        event($this->event->setParams($object,  Action::CREATING));
//    }

    public function created($object)
    {
        event($this->event->setParams($object, Action::CREATED));
    }

//    public function updating($object)
//    {
//        event($this->event->setParams($object,  Action::UPDATING));
//    }


    public function updated($object)
    {
        event($this->event->setParams($object, Action::UPDATED));
    }

//    public function saving($object)
//    {
//        event($this->event->setParams($object,  Action::SAVING));
//    }
//
//    public function saved($object)
//    {
//        event($this->event->setParams($object,  Action::SAVED));
//    }
//
//    public function deleting($object)
//    {
//        event($this->event->setParams($object,  Action::DELETING));
//    }

    public function deleted($object)
    {
        event($this->event->setParams($object, Action::DELETED));
    }

//    public function restoring($object)
//    {
//        event($this->event->setParams($object,  Action::RESTORING));
//    }
//
//    public function restored($object)
//    {
//        event($this->event->setParams($object,  Action::RESTORED));
//    }
//
//    public function forceDeleted($object)
//    {
//        event($this->event->setParams($object,  Action::DELETED));
//    }

}

