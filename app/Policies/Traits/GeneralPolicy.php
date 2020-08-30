<?php

namespace App\Policies\Traits;

use App\User;

trait GeneralPolicy
{
    /**
     * Check for super user and mode
     * @param $user
     * @param $ability
     * @return bool
     */
    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param $object
     * @return mixed
     */
    public function view(User $user, $object)
    {
        return $this->haveRightOn($user, $object);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasVerifiedEmail();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param $object
     * @return mixed
     */
    public function update(User $user, $object)
    {
        return $this->haveRightOn($user, $object);
    }


    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param $object
     * @return mixed
     */
    public function delete(User $user, $object)
    {
        return $this->haveRightOn($user, $object);
    }


    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param $object
     * @return mixed
     */
    public function restore(User $user, $object)
    {
        return $this->haveRightOn($user, $object);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param $object
     * @return mixed
     */
    public function forceDelete(User $user, $object)
    {
        return $this->haveRightOn($user, $object);
    }
}
