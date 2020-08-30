<?php

namespace App\Repositories;

use App\Models\Invitation;
use App\Models\Reservation;
use App\User;
use App\Repositories\Traits\FormatPaginationTrait;
use App\Repositories\Traits\GeneralFunctionTrait;
use Illuminate\Pagination\LengthAwarePaginator as paginate;
use Illuminate\Support\Collection;

//use Your Model

/**
 * Class RestaurantResource.
 */
class InvitationRepository
{
    use FormatPaginationTrait, GeneralFunctionTrait;

    protected $user;

    /**
     * get a list of Restaurants
     * @return Collection
     */
    public function getAll(): Collection
    {
        $invitations = $this->user->isSuperAdmin() ? Invitation::paginate() : self::getByUser($this->user);
        return self::formatPagination($invitations);
    }

    /**
     * get A Invitation with id
     * @param $id
     * @return Invitation
     */
    public function get($id): Invitation
    {
        return Invitation::findOrfail($id);
    }

    /**
     * Create a new Invitation
     * @param $request
     * @return array
     */
    public function store($request): array
    {
        return $this->user->invitations()->create($request->all())->format();
    }

    /**
     * @param Reservation $reservation
     * @return Collection
     */
    public function getByReservation(Reservation $reservation): Collection
    {
        return self::formatPagination($reservation->invitations()->paginate());
    }

    /**
     * @param User $user
     * @return paginate
     */
    public function getByUser(User $user): paginate
    {
        return $user->invitations()->paginate();
    }
}
