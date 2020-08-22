<?php

namespace App\Repositories;

use App\Models\Invitation;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as paginate;
use Illuminate\Support\Facades\Redis;

//use Your Model

/**
 * Class UserResource.
 */
class UserRepository
{
    /**
     * get a list of Users
     * @return paginate
     */
    public static function getAll(): paginate
    {
        return User::paginate();
    }

    /**
     * get A User with id
     * @param $id
     * @return User
     */
    public static function get($id): User
    {
        return User::findOrfail($id);
    }

    /**
     * get a format User with id
     * @param $id
     * @return array
     */
    public static function show($id): array
    {
        $key = "UserRepository_Show_" . $id;
        if (!Redis::hgetall($key)) {
            Redis::hmset($key, self::get($id)->format());
        }
        return Redis::hgetall($key);
    }

    /**
     * @param User $user
     * @return paginate
     */
    public static function getReservations(User $user): paginate
    {
        return $user->reservations()->paginate();
    }

    /**
     * @param Restaurant $restaurant
     * @return paginate
     */
    public static function getByRestaurant(Restaurant $restaurant): paginate
    {
        return $restaurant->owners()->paginate();
    }

    /**
     * @param Invitation $invitation
     * @return array
     */
    public static function getByInvitation(Invitation $invitation): array
    {
        return $invitation->user()->get()->first()->format();
    }

    /**
     * @param Reservation $reservation
     * @return array
     */
    public static function getByReservation(Reservation $reservation): array
    {
        return $reservation->user()->get()->first()->format();
    }
}
