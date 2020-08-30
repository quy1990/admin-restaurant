<?php

namespace App\Policies;

use App\Models\Comment;
use App\Policies\Traits\GeneralPolicy;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization, GeneralPolicy;

    /**
     * Check right on a object
     *
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function haveRightOn(User $user, Comment $comment)
    {
        return $user->hasVerifiedEmail();
    }
}

