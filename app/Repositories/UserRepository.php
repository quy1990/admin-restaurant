<?php

namespace App\Repositories;

use App\Models\Invitation;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;
use App\Repositories\Traits\FormatPaginationTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as paginate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Redis;

//use Your Model

/**
 * Class UserResource.
 */
class UserRepository
{
    use FormatPaginationTrait;
    /**
     * get a list of Users
     * @return Collection
     */
    public static function getAll(): Collection
    {
        $users = User::paginate();

        return self::formatPagination($users);
    }

    /**
     * get A User with id
     * @param $id
     * @return User
     */
    public static function get($id): User
    {
        return User::findOrFail($id);
    }

    /**
     * get a format User with id
     * @param $id
     * @return array
     */
    public static function show($id): array
    {
        return self::get($id)->format();
    }

    /**
     * @param User $user
     * @return Collection
     */
    public static function getReservations(User $user): Collection
    {
        $users = $user->reservations()->paginate();

        return self::formatPagination($users);
    }

    /**
     * @param Restaurant $restaurant
     * @return Collection
     */
    public static function getByRestaurant(Restaurant $restaurant): Collection
    {
        $users = $restaurant->owners()->paginate();

        return self::formatPagination($users);
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
