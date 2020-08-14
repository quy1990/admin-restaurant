<?php

namespace App\Policies;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestaurantPolicy
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
     * @param Restaurant $restaurant
     * @return mixed
     */
    public function view(User $user, Restaurant $restaurant)
    {
        return true;
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
     * @param Restaurant $restaurant
     * @return mixed
     */
    public function update(User $user, Restaurant $restaurant)
    {
        return in_array($restaurant->id, $user->ownedRestaurants()->pluck('restaurant_id'));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Restaurant $restaurant
     * @return mixed
     */
    public function delete(User $user, Restaurant $restaurant)
    {
        return in_array($restaurant->id, $user->ownedRestaurants()->pluck('restaurant_id'));
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Restaurant $restaurant
     * @return mixed
     */
    public function restore(User $user, Restaurant $restaurant)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Restaurant $restaurant
     * @return mixed
     */
    public function forceDelete(User $user, Restaurant $restaurant)
    {
        return true;
    }
}
