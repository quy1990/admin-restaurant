<?php

namespace App\Repositories;

use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

//use Your Model

/**
 * Class ReservationRepository.
 */
class ReservationRepository
{
    /**
     * get a list of Restaurants
     * @return LengthAwarePaginator
     */
    public static function getAll(): LengthAwarePaginator
    {
        return Reservation::paginate();
    }

    /**
     * get A Reservation with id
     * @param $id
     * @return Reservation | null
     */
    public static function get($id)
    {
        return Reservation::findOrFail($id);
    }

    /**
     * get a format Reservation with id
     * @param $id
     * @return array
     */
    public static function show($id): array
    {
        return self::get($id)->format();
    }

    /**
     * Create a new Reservation
     * @param Request $request
     * @param User $user
     * @return Reservation
     */
    public static function store(Request $request, User $user): Reservation
    {
        return $user->reservations()->create($request->all());
    }

    /**
     * update a Reservation
     * @param Request $request
     * @param int $id
     * @return array
     */
    public static function update(Request $request, int $id): array
    {
        self::get($id)->update($request->all());

        return self::show($id);
    }

    /**
     * delete a row in Database
     * @param Reservation $reservation
     * @return bool|null
     */
    public static function delete(Reservation $reservation)
    {
        return $reservation->delete();
    }

    /**
     * get all Reservation by User
     * @param User $user
     * @return Collection
     */
    public static function getByUser(User $user): Collection
    {
        return $user->reservations()->get();
    }

    /**
     * get all reservations by Restaurant
     * @param Restaurant $restaurant
     * @return Collection
     */
    public static function getByRestaurant(Restaurant $restaurant): Collection
    {
        return $restaurant->reservations()->get();
    }
}
