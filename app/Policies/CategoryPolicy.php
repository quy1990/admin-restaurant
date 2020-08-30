<?php

namespace App\Policies;

use App\Models\Category;
use App\Policies\Traits\GeneralPolicy;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization, GeneralPolicy;

    /**
     * Check right on a object
     *
     * @param User $user
     * @param Category $category
     * @return bool
     */
    public function haveRightOn(User $user, Category $category)
    {
        return $user->hasVerifiedEmail();
    }
}

