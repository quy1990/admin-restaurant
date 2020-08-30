<?php

namespace App\Policies;

use App\Models\People;
use App\Policies\Traits\GeneralPolicy;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PeoplePolicy
{
    use HandlesAuthorization, GeneralPolicy;

    /**
     * Check right on a object
     *
     * @param User $user
     * @param People $people
     * @return bool
     */
    public function haveRightOn(User $user, People $people)
    {
        return $user->id == $people->user_id;
    }
}

