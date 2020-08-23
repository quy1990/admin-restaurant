<?php

namespace App\Repositories;

use App\Events\CustomerReserveEvent;
use App\Models\Invitation;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;
use App\Repositories\Traits\FormatPaginationTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as paginate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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
     * @return Collection
     */
    public static function getAll(): Collection
    {
        $reservations = Reservation::paginate();

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
     * @return Model
     */
    public static function store(Request $request, User $user): Model
    {
        $reservation = $user->reservations()->create($request->all());

        event(new CustomerReserveEvent($reservation));

        return $reservation;
    }

    /**
     * update a Reservation
     * @param Request $request
     * @param int $id
     * @return array
     */
    public static function update(Request $request, int $id): array
    {
        return self::get($id)->format();
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
     * @return Collection
     */
    public static function getByUser(User $user): Collection
    {
        $reservations = $user->reservations()->paginate();

        return self::formatPagination($reservations);
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
