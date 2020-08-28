<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Hook into user deleting event.
     *
     * @param User $user
     * @return void
     */
    public function deleting(User $user)
    {

    }

    public function created(User $user)
    {
        //
    }

    public function restoring(User $user)
    {
        //
    }
}
