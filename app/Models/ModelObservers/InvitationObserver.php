<?php

namespace App\Models\ModelObservers;

use App\Events\CustomerInviteEvent;
use App\Events\CustomerRemoveInviteEvent;
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
        event(new CustomerRemoveInviteEvent($invitation));
    }

    public function created(Invitation $invitation)
    {
        event(new CustomerInviteEvent($invitation));
    }

    public function restoring(Invitation $invitation)
    {
        //
    }
}
