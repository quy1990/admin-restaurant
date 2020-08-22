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
use Illuminate\Support\Facades\Redis;

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
    public static function getAll(): paginate
    {
        return Reservation::paginate();
    }

    /**
     * get A Reservation with id
     * @param $id
     * @return Reservation | null
     */
    public static function get($id): Reservation
    {
        return Reservation::findOrFail($id);
    }

    /**
     * get a format Reservation with id
     * @param Reservation $reservation
     * @return array
     */
    public static function show(Reservation $reservation): array
    {
        $key = "ReservationRepository_Show_" . $reservation->id;
        if (!Redis::hgetall($key)) {
            Redis::hmset($key, $reservation->format());
        }
        return Redis::hgetall($key);
    }

    /**
     * Create a new Reservation
     * @param Request $request
     * @param User $user
     * @return Model
     */
    public static function store(Request $request, User $user): Model
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
        $key = "ReservationRepository_Show_" . $id;
        Redis::hmset($key, self::get($id)->format());
        return Redis::hgetall($key);
    }

    /**
     * delete a row in Database
     * @param Reservation $reservation
     * @return bool|null
     */
    public static function delete(Reservation $reservation)
    {
        $key = 'ReservationRepository_Show_' . $reservation->id;
        Redis::del($key);
        return $reservation->delete();
    }

    /**
     * get all Reservation by User
     * @param User $user
     * @return paginate
     */
    public static function getByUser(User $user): paginate
    {
        return $user->reservations()->paginate();
    }

    /**
     * get all reservations by Restaurant
     * @param Restaurant $restaurant
     * @return paginate
     */
    public static function getByRestaurant(Restaurant $restaurant): paginate
    {
        return $restaurant->reservations()->paginate();
    }

    /**
     * get all reservations by Restaurant
     * @param Invitation $invitation
     * @return array
     */
    public static function getByInvitation(Invitation $invitation): array
    {
        return $invitation->reservation()->get()->first()->format();
    }
}
