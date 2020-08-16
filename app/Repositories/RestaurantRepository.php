<?php

namespace App\Repositories;

use App\Models\Invitation;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as paginate;
use Illuminate\Database\Eloquent\Model;
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
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public static function getAll(Request $request): LengthAwarePaginator
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
    public static function show($id): array
    {
        return self::get($id)->format();
    }

    /**
     * Create a new Restaurant
     *
     * @param Request $request
     * @param User $user
     * @return Model
     */
    public static function store(Request $request, User $user): Model
    {
        return $user->ownedRestaurants()->create($request->all());
    }

    /**
     * update a Restaurant
     * @param $request
     * @param $id
     * @return Model
     */
    public static function update($request, int $id): Model
    {
        self::get($id)->update($request->all());
        return self::get($id);
    }

    /**
     * delete a row in Database
     * @param Restaurant $restaurant
     * @return bool|null
     * @throws \Exception
     */
    public static function delete(Restaurant $restaurant)
    {
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
     */
    public static function getByInvitation(Invitation $invitation)
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
