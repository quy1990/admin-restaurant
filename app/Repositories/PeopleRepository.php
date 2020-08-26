<?php

namespace App\Repositories;

use App\Models\Invitation;
use App\Models\People;
use App\Models\Reservation;
use App\User;
use App\Repositories\Traits\FormatPaginationTrait;
use App\Repositories\Traits\GeneralFunctionTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as paginate;
use Illuminate\Support\Collection;

/**
 * Class RestaurantResource.
 */
class PeopleRepository
{
    use FormatPaginationTrait, GeneralFunctionTrait;

    protected $user;

    /**
     * get a list of Restaurants
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        $peoples = $this->user->isSuperAdmin() ? People::paginate() : self::getByUser($this->user);
        return self::formatPagination($peoples);
    }

    /**
     * get A People by id
     * @param $id
     * @return People
     */
    public function get($id): People
    {
        return People::findOrfail($id);
    }

    /**
     * get a format People by id
     * @param People $people
     * @return array
     */
    public function show(People $people): array
    {
        return $people->format();
    }

    /**
     * Create a new People
     * @param array $item
     * @return array
     */
    public function store(array $item): array
    {
        return $this->user->peoples()->create($item)->format();
    }

    /**
     * delete a row in Database
     * @param People $people
     * @return bool|null
     * @throws \Exception
     */
    public function delete(People $people)
    {
        return $people->delete();
    }

    /**
     * @param Invitation $invitation
     * @return Collection
     */
    public function getByInvitation(Invitation $invitation): Collection
    {
        return self::formatPagination($invitation->peoples()->paginate());
    }

    /**
     * @param Reservation $reservation
     * @return Collection
     */
    public function getByReservation(Reservation $reservation): Collection
    {
        return self::formatPagination($reservation->peoples()->paginate());
    }


    /**
     * @param User $user
     * @return paginate
     */
    public function getByUser(User $user): paginate
    {
        return $user->peoples()->paginate();
    }
}
