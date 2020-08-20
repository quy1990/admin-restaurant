<?php

namespace App\Policies;

use App\Models\Reservation;
use App\User;
use App\Models\User as Customer;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservationPolicy
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
     * @param Reservation $reservation
     * @return mixed
     */
    public function view(User $user, Reservation $reservation)
    {
        return $this->haveRightOn($user, $reservation);
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
     * @param Reservation $reservation
     * @return mixed
     */
    public function update(User $user, Reservation $reservation)
    {
        return $this->haveRightOn($user, $reservation);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Reservation $reservation
     * @return mixed
     */
    public function delete(User $user, Reservation $reservation)
    {
        return $this->haveRightOn($user, $reservation);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Reservation $reservation
     * @return mixed
     */
    public function restore(User $user, Reservation $reservation)
    {
        return $this->haveRightOn($user, $reservation);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Reservation $reservation
     * @return mixed
     */
    public function forceDelete(User $user, Reservation $reservation)
    {
        return $this->haveRightOn($user, $reservation);
    }

    /**
     * Check right on a object
     *
     * @param Customer $user
     * @param Reservation $reservation
     * @return bool
     */
    public function haveRightOn(User $user, Reservation $reservation)
    {
        return $reservation->user_id == $user->id ||
            in_array($reservation->restaurant_id, Customer::find($user->id)->ownedRestaurants()->pluck('restaurant_id')->toArray());

    }
}
