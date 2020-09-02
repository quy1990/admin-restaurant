<?php

namespace App\Repositories;

use App\Models\Reservation;
use App\Models\Restaurant;
use App\Repositories\Traits\FormatPaginationTrait;
use App\Repositories\Traits\GeneralFunctionTrait;
use App\User;
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
        $reservations = $this->user->isSuperAdmin() ? Reservation::paginate() : $this->user->reservations()->paginate();
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
     * @param Reservation $reservation
     * @return array
     */
    public function getRestaurant(Reservation $reservation): array
    {
        return $reservation->restaurant->format();
    }

    /**
     * @param Reservation $reservation
     * @return array
     */
    public function getUser(Reservation $reservation): array
    {
        return $reservation->user->format();
    }

    /**
     * @param Reservation $reservation
     * @return Collection
     */
    public function getInvitations(Reservation $reservation): Collection
    {
        return self::formatPagination($reservation->invitations()->paginate());
    }

    /**
     * @param Reservation $reservation
     * @return Collection
     */
    public function getPeoples(Reservation $reservation): Collection
    {
        return self::formatPagination($reservation->peoples()->paginate());
    }
}
