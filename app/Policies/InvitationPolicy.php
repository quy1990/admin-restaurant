<?php

namespace App\Policies;

use App\Models\Invitation;
use App\Policies\Traits\GeneralPolicy;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitationPolicy
{
    use HandlesAuthorization, GeneralPolicy;

    /**
     * Check right on a object
     *
     * @param User $user
     * @param Invitation $invitation
     * @return bool
     */
    public function haveRightOn(User $user, Invitation $invitation)
    {
        return $user->id == $invitation->user_id;
    }

}
