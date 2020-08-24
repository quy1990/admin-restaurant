<?php

namespace App\Repositories;

use App\Models\Invitation;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;
use App\Repositories\Traits\FormatPaginationTrait;
use App\Repositories\Traits\GeneralFunctionTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as paginate;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

//use Your Model

/**
 * Class ReservationRepository.
 */
class ReservationRepository
{
    use FormatPaginationTrait, GeneralFunctionTrait;

    protected $user;

    /**
     * get a list of Restaurants
     * @return Collection
     */
    public function getAll(): Collection
    {
        $reservations = $this->user->isSuperAdmin() ? Reservation::paginate() : self::getByUser($this->user);
        return self::formatPagination($reservations);

    }

    /**
     * get A Reservation with id
     * @param $id
     * @return Reservation | null
     */
    public function get($id): Reservation
    {
        return Reservation::findOrFail($id);
    }

    /**
     * get a format Reservation with id
     * @param Reservation $reservation
     * @return array
     */
    public function show(Reservation $reservation): array
    {
        return $reservation->format();
    }

    /**
     * Create a new Reservation
     * @param Request $request
     * @param User $user
     * @return array
     */
    public function store(Request $request, User $user): array
    {
        return $user->reservations()->create($request->all())->format();
    }

    /**
     * delete a row in Database
     * @param Reservation $reservation
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Reservation $reservation)
    {
        return $reservation->delete();
    }

    /**
     * get all Reservation by User
     * @param User $user
     * @return paginate
     */
    public function getByUser(User $user): paginate
    {
        return $user->reservations()->paginate();
    }

    /**
     * get all reservations by Restaurant
     * @param Restaurant $restaurant
     * @return Collection
     */
    public function getByRestaurant(Restaurant $restaurant): Collection
    {
        return self::formatPagination($restaurant->reservations()->paginate());
    }

    /**
     * get all reservations by Restaurant
     * @param Invitation $invitation
     * @return array
     */
    public function getByInvitation(Invitation $invitation): array
    {
        return $invitation->reservation()->get()->first()->format();
    }
}
