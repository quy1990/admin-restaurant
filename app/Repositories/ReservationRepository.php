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
     * get all Reservation by User
     * @param User $user
     * @return Collection
     */
    public function getByUser(User $user): Collection
    {
        return self::formatPagination($user->reservations()->paginate());
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
}
