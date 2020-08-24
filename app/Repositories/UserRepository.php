<?php

namespace App\Repositories;

use App\Models\Invitation;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;
use App\Repositories\Traits\FormatPaginationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

//use Your Model

/**
 * Class UserResource.
 */
class UserRepository
{
    use FormatPaginationTrait;
    /**
     * get a list of Users
     * @param Request $request
     * @return Collection
     */
    public static function getAll(Request $request): Collection
    {

        $user = User::find($request->user()->id);
        $users = $user->isSuperAdmin() ? User::paginate() : null;
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
     * @param User $user
     * @return array
     */
    public static function show(User $user): array
    {
        return $user->format();
    }

    /**
     * @param User $user
     * @return Collection
     */
    public static function getReservations(User $user): Collection
    {
        $reservations = $user->reservations()->paginate();

        return self::formatPagination($reservations);
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
