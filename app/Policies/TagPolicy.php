<?php

namespace App\Policies;

use App\Models\Tag;
use App\Policies\Traits\GeneralPolicy;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization, GeneralPolicy;

    /**
     * Check right on a object
     *
     * @param User $user
     * @param Tag $tag
     * @return bool
     */
    public function haveRightOn(User $user, Tag $tag)
    {
        return $user->hasVerifiedEmail();
    }
}

