<?php

namespace App\Policies;

use App\Models\Restaurant;
use App\User;
use App\Policies\Traits\GeneralPolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestaurantPolicy
{
    use HandlesAuthorization, GeneralPolicy;

    /**
     * Check right on a object
     *
     * @param User $user
     * @param Restaurant $restaurant
     * @return bool
     */
    public function haveRightOn(User $user, Restaurant $restaurant)
    {
        return in_array($restaurant->id, $user->ownedRestaurants()->pluck('restaurant_id')->toArray());
    }
}
