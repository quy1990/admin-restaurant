<?php

namespace App\Repositories;

use App\Models\Restaurant;
use App\Models\User;
use Highlight\Mode;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as paginate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

//use Your Model

/**
 * Class UserResource.
 */
class UserRepository
{
    /**
     * get a list of Users
     * @return LengthAwarePaginator
     */
    public static function getAll():LengthAwarePaginator
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
    public static function show($id):array
    {
        return self::get($id)->format();
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
}
