<?php

namespace App\Repositories;

use App\Repositories\Traits\FormatPaginationTrait;
use App\User;
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
    public function getRestaurants(User $user): Collection
    {
        return self::formatPagination($user->restaurants()->paginate());
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function ownedRestaurants(User $user): Collection
    {
        return self::formatPagination($user->ownedRestaurants()->paginate());
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getInvitations(User $user): Collection
    {
        return self::formatPagination($user->invitations()->paginate());
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getPeoples(User $user): Collection
    {
        return self::formatPagination($user->peoples()->paginate());
    }
}
