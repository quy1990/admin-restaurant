<?php

namespace App\Models\ModelObservers;

use App\Events\CustomerInvitedPeopleEvent;
use App\Models\People;

class PeopleObserver
{
    /**
     * Hook into user deleting event.
     *
     * @param People $people
     * @return void
     */
    public function deleting(People $people)
    {

    }

    public function created(People $people)
    {
        event(new CustomerInvitedPeopleEvent($people));
    }

    public function restoring(People $people)
    {
        //
    }
}
