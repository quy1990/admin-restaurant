<?php

namespace App\Repositories;

use App\Models\Invitation;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\User;
use App\Repositories\Traits\FormatPaginationTrait;
use Illuminate\Support\Collection;

//use Your Model

/**
 * Class UserResource.
 */
class UserRepository
{
    use FormatPaginationTrait;

    protected $user;

    /**
     * get a list of Restaurants
     * @return Collection
     */
    public function getAll(): Collection
    {
        $users = $this->user->isSuperAdmin() ? User::paginate() : null;
        return self::formatPagination($users);
    }

    /**
     * get A User with id
     * @param $id
     * @return User
     */
    public function get($id): User
    {
        return User::findOrFail($id);
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getReservations(User $user): Collection
    {
        return self::formatPagination($user->reservations()->paginate());
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getPeoples(User $user): Collection
    {
        return self::formatPagination($user->peoples()->paginate());
    }

    /**
     * @param Restaurant $restaurant
     * @return Collection
     */
    public function getByRestaurant(Restaurant $restaurant): Collection
    {
        return self::formatPagination($restaurant->owners()->paginate());
    }

    /**
     * @param Invitation $invitation
     * @return array
     */
    public function getByInvitation(Invitation $invitation): array
    {
        return $invitation->user()->get()->first()->format();
    }

    /**
     * @param Reservation $reservation
     * @return array
     */
    public function getByReservation(Reservation $reservation): array
    {
        return $reservation->user()->get()->first()->format();
    }
}
