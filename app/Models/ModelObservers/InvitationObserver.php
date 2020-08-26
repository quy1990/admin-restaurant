<?php

namespace App\Models\ModelObservers;

use App\Events\CreateAnInvitationEvent;
use App\Events\CustomerRemovedInvitationEvent;
use App\Models\Invitation;

class InvitationObserver
{
    /**
     * Hook into user deleting event.
     *
     * @param Invitation $invitation
     * @return void
     */
    public function deleting(Invitation $invitation)
    {
        event(new CustomerRemovedInvitationEvent($invitation));
    }

    public function created(Invitation $invitation)
    {
        event(new CreateAnInvitationEvent($invitation));
    }

    public function restoring(Invitation $invitation)
    {
        //
    }
}
