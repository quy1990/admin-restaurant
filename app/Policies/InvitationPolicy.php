<?php

namespace App\Policies;

use App\Models\Invitation;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitationPolicy
{
    use HandlesAuthorization;

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
     * @param Invitation $invitation
     * @return mixed
     */
    public function view(User $user, Invitation $invitation)
    {
        return (
            $user->id == $invitation->user_id ||
            in_array($invitation->user_id, $user->ownedRestaurants()->pluck('user_id')));
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
     * @param Invitation $invitation
     * @return mixed
     */
    public function update(User $user, Invitation $invitation)
    {
        return (
            $user->id == $invitation->reservation->user_id ||
            in_array($invitation->reservation->user_id, $user->ownedRestaurants()->pluck('restaurant_id')));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Invitation $invitation
     * @return mixed
     */
    public function delete(User $user, Invitation $invitation)
    {
        return (
            $user->id == $invitation->reservation->user_id ||
            in_array($invitation->reservation->user_id, $user->ownedRestaurants()->pluck('restaurant_id')));
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Invitation $invitation
     * @return mixed
     */
    public function restore(User $user, Invitation $invitation)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Invitation $invitation
     * @return mixed
     */
    public function forceDelete(User $user, Invitation $invitation)
    {
        return true;
    }
}
