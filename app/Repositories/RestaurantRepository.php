<?php

namespace App\Repositories;

use App\Models\Invitation;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Repositories\Traits\FormatPaginationTrait;
use App\Repositories\Traits\GeneralFunctionTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;


/**
 * Class RestaurantResource.
 */
class RestaurantRepository
{
    use FormatPaginationTrait, GeneralFunctionTrait;

    protected $user;

    /**
     * get a list of Restaurants
     * @return Collection
     */
    public function getAll(): Collection
    {
        $restaurants = $this->user->isSuperAdmin() ? Restaurant::paginate() : $this->user->ownedRestaurants()->paginate();
        return self::formatPagination($restaurants);
    }

    /**
     * @param $id
     * @return Restaurant | null
     */
    public function get($id): Restaurant
    {
        return Restaurant::findOrFail($id);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request): array
    {
        return $this->user->ownedRestaurants()->create($request->all())->format();
    }

    /**
     * @param Restaurant $restaurant
     * @return Collection
     */
    public function getReservations(Restaurant $restaurant): Collection
    {
        return self::formatPagination($restaurant->reservations()->paginate());
    }

    /**
     * @param Restaurant $restaurant
     * @return Collection
     */
    public function getInvitations(Restaurant $restaurant): Collection
    {
        return self::formatPagination($restaurant->invitations()->paginate());
    }

    /**
     * @param Restaurant $restaurant
     * @return Collection
     */
    public function getOwners(Restaurant $restaurant): Collection
    {
        return self::formatPagination($restaurant->owners()->paginate());
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getByOwner(User $user): Collection
    {
        return self::formatPagination($user->restaurants()->paginate());
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getByUser(User $user): Collection
    {
        return self::formatPagination($user->ownedRestaurants()->paginate());
    }

    /**
     * @param Invitation $invitation
     * @return array
     */
    public function getByInvitation(Invitation $invitation): array
    {
        return $invitation->restaurant()->get()->first()->format();
    }

    /**
     * @param Reservation $reservation
     * @return array
     */
    public function getByReservation(Reservation $reservation): array
    {
        return $reservation->restaurant()->get()->first()->format();
    }

    /**
     * @param Restaurant $restaurant
     * @return Collection
     */
    public function getImages(Restaurant $restaurant): Collection
    {
        return self::formatPagination($restaurant->images()->paginate());
    }

    /**
     * @param Restaurant $restaurant
     * @return Collection
     */
    public function getTags(Restaurant $restaurant): Collection
    {
        return self::formatPagination($restaurant->tags()->paginate());
    }


    /**
     * @param Restaurant $restaurant
     * @return Collection
     */
    public function getCategories(Restaurant $restaurant): Collection
    {
        return self::formatPagination($restaurant->categories()->paginate());
    }

    /**
     * @param Restaurant $restaurant
     * @return Collection
     */
    public function getComments(Restaurant $restaurant): Collection
    {
        return self::formatPagination($restaurant->Comments()->paginate());
    }
}
