<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Policies\Traits\GeneralPolicy;
use App\User;
use App\Models\User as Customer;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservationPolicy
{
    use HandlesAuthorization, GeneralPolicy;

    /**
     * Check right on a object
     *
     * @param User $user
     * @param Reservation $reservation
     * @return bool
     */
    public function haveRightOn(User $user, Reservation $reservation)
    {
        return $reservation->user_id == $user->id ||
            in_array($reservation->restaurant_id, Customer::find($user->id)->ownedRestaurants()->pluck('restaurant_id')->toArray());

    }
}
