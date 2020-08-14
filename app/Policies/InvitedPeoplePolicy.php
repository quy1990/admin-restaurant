<?php

namespace App\Policies;

use App\Models\InvitedPeople;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitedPeoplePolicy
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
     * @param InvitedPeople $invitedPeople
     * @return mixed
     */
    public function view(User $user, InvitedPeople $invitedPeople)
    {
        return $user->id == $invitedPeople->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param InvitedPeople $invitedPeople
     * @return mixed
     */
    public function update(User $user, InvitedPeople $invitedPeople)
    {
        return $user->id == $invitedPeople->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param InvitedPeople $invitedPeople
     * @return mixed
     */
    public function delete(User $user, InvitedPeople $invitedPeople)
    {
        return $user->id == $invitedPeople->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param InvitedPeople $invitedPeople
     * @return mixed
     */
    public function restore(User $user, InvitedPeople $invitedPeople)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param InvitedPeople $invitedPeople
     * @return mixed
     */
    public function forceDelete(User $user, InvitedPeople $invitedPeople)
    {
        return true;
    }
}
