<?php

namespace App\Policies;

use App\Models\Image;
use App\Policies\Traits\GeneralPolicy;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImagePolicy
{
    use HandlesAuthorization, GeneralPolicy;

    /**
     * Check right on a object
     *
     * @param User $user
     * @param Image $image
     * @return bool
     */
    public function haveRightOn(User $user, Image $image)
    {
        return $user->hasVerifiedEmail();
    }
}

