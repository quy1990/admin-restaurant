<?php

namespace App\Repositories;

use App\Models\Invitation;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as paginate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

//use Your Model

/**
 * Class RestaurantResource.
 */
class RestaurantRepository
{
    /**
     * get a list of Restaurants
     * @param Request $request
     * @return paginate
     */
    public static function getAll(Request $request): paginate
    {
        $user = User::find($request->user()->id);
        return User::find($request->user()->id)->isSuperAdmin() ? Restaurant::paginate() : self::getByUser($user);
    }

    /**
     * @param $id
     * @return Restaurant
     */
    public static function get($id): Restaurant
    {
        return Restaurant::findOrfail($id);
    }

    /**
     * @param Restaurant $restaurant
     * @return array
     */
    public static function show(Restaurant $restaurant): array
    {
        $key = "RestaurantRepository_Show_" . $restaurant->id;
        if (!Redis::hgetall($key)) {
            Redis::hmset($key, $restaurant->format());
        }
        return Redis::hgetall($key);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return Model
     */
    public static function store(Request $request, User $user): Model
    {
        return $user->ownedRestaurants()->create($request->all());
    }

    /**
     * @param $request
     * @param $id
     * @return Model
     */
    public static function update($request, int $id): Model
    {
        self::get($id)->update($request->all());
        $key = "RestaurantRepository_Show_" . $id;
        Redis::hmset($key, self::get($id)->format());
        return Redis::hgetall($key);
    }

    /**
     * @param Restaurant $restaurant
     * @return bool|null
     * @throws \Exception
     */
    public static function delete(Restaurant $restaurant)
    {
        $key = 'RestaurantRepository_Show_' . $restaurant->id;
        Redis::del($key);
        return $restaurant->delete();
    }

    /**
     * @param Restaurant $restaurant
     * @return paginate
     */
    public static function getReservations(Restaurant $restaurant): paginate
    {
        return $restaurant->reservations()->paginate();
    }

    /**
     * @param Restaurant $restaurant
     * @return paginate
     */
    public static function getInvitations(Restaurant $restaurant): paginate
    {
        return $restaurant->invitations()->paginate();
    }

    /**
     * @param Restaurant $restaurant
     * @return paginate
     */
    public static function getOwners(Restaurant $restaurant): paginate
    {
        return $restaurant->owners()->paginate();
    }

    /**
     * @param User $user
     * @return paginate
     */
    public static function getByUser(User $user): paginate
    {
        return $user->ownedRestaurants()->paginate();
    }

    /**
     * @param Invitation $invitation
     * @return array
     */
    public static function getByInvitation(Invitation $invitation): array
    {
        return $invitation->restaurant()->get()->first()->format();
    }

    /**
     * @param Reservation $reservation
     * @return array
     */
    public static function getByReservation(Reservation $reservation): array
    {
        return $reservation->restaurant()->get()->first()->format();
    }
}
