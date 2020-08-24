<?php

namespace App\Repositories;

use App\Models\Invitation;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;
use App\Repositories\Traits\FormatPaginationTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as paginate;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

//use Your Model

/**
 * Class ReservationRepository.
 */
class ReservationRepository
{
    use FormatPaginationTrait;
    /**
     * get a list of Restaurants
     * @param Request $request
     * @return Collection
     */
    public static function getAll(Request $request): Collection
    {
        $user = User::find($request->user()->id);
        $reservations = $user->isSuperAdmin() ? Reservation::paginate() : self::getByUser($user);
        return self::formatPagination($reservations);

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
        return $reservation->format();
    }

    /**
     * Create a new Reservation
     * @param Request $request
     * @param User $user
     * @return array
     */
    public static function store(Request $request, User $user): array
    {
        return $user->reservations()->create($request->all())->format();
    }

    /**
     * update a Reservation
     * @param Request $request
     * @param int $id
     * @return array
     */
    public static function update(Request $request, int $id): array
    {
        return self::get($id)->update($request->all())->format();
    }

    /**
     * delete a row in Database
     * @param Reservation $reservation
     * @return bool|null
     * @throws \Exception
     */
    public static function delete(Reservation $reservation)
    {
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
     * @return Collection
     */
    public static function getByRestaurant(Restaurant $restaurant): Collection
    {
        $reservations = $restaurant->reservations()->paginate();

        return self::formatPagination($reservations);
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
