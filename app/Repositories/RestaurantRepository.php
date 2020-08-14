<?php

namespace App\Repositories;

use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

//use Your Model

/**
 * Class RestaurantResource.
 */
class RestaurantRepository
{
    /**
     * get a list of Restaurants
     * @return LengthAwarePaginator
     */
    public static function getAll():LengthAwarePaginator
    {
        return Restaurant::paginate();
    }

    /**
     * get A Restaurant with id
     * @param $id
     * @return Restaurant
     */
    public static function get($id): Restaurant
    {
        return Restaurant::findOrfail($id);
    }

    /**
     * get a format Restaurant with id
     * @param $id
     * @return array
     */
    public static function show($id):array
    {
        return self::get($id)->format();
    }

    /**
     * Create a new Restaurant
     *
     * @param Request $request
     * @param User $user
     * @return Restaurant
     */
    public static function store(Request $request, User $user): Restaurant
    {
        return $user->ownedRestaurants()->create($request->all());
    }

    /**
     * update a Restaurant
     * @param $request
     * @param $id
     * @return array
     */
    public static function update($request, $id):array
    {
        self::get($id)->update($request->all());

        return self::show($id);
    }

    /**
     * delete a row in Database
     * @param Restaurant $restaurant
     * @return bool|null
     */
    public static function delete(Restaurant $restaurant)
    {
        return $restaurant->delete();
    }

    /**
     * @param Restaurant $restaurant
     * @return LengthAwarePaginator
     */
    public static function getReservations(Restaurant $restaurant): LengthAwarePaginator
    {
        return $restaurant->reservations()->paginate();
    }

    /**
     * @param User $user
     * @return LengthAwarePaginator
     */
    public static function getByUser(User $user): LengthAwarePaginator
    {
        return $user->ownedRestaurants()->paginate();
    }
}
