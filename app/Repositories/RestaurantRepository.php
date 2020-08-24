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


/**
 * Class RestaurantResource.
 */
class RestaurantRepository
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
        $restaurants = $user->isSuperAdmin() ? Restaurant::paginate() : self::getByUser($user);
        return self::formatPagination($restaurants);
    }

    /**
     * @param $id
     * @return Restaurant | null
     */
    public static function get($id): Restaurant
    {
        return Restaurant::findOrFail($id);
    }

    /**
     * @param Restaurant $restaurant
     * @return array
     */
    public static function show(Restaurant $restaurant): array
    {
        return $restaurant->format();
    }

    /**
     * @param Request $request
     * @param User $user
     * @return array
     */
    public static function store(Request $request, User $user): array
    {
        return $user->ownedRestaurants()->create($request->all())->format();
    }

    /**
     * @param $request
     * @param $id
     * @return array
     */
    public static function update($request, int $id): array
    {
        return self::get($id)->update($request->all())->format();
    }

    /**
     * @param Restaurant $restaurant
     * @return bool|null
     * @throws \Exception
     */
    public static function delete(Restaurant $restaurant)
    {
        return $restaurant->delete();
    }

    /**
     * @param Restaurant $restaurant
     * @return Collection
     */
    public static function getReservations(Restaurant $restaurant): Collection
    {
        $restaurants = $restaurant->reservations()->paginate();
        return self::formatPagination($restaurants);
    }

    /**
     * @param Restaurant $restaurant
     * @return Collection
     */
    public static function getInvitations(Restaurant $restaurant): Collection
    {
        $restaurants = $restaurant->invitations()->paginate();
        return self::formatPagination($restaurants);
    }

    /**
     * @param Restaurant $restaurant
     * @return Collection
     */
    public static function getOwners(Restaurant $restaurant): Collection
    {
        $restaurants = $restaurant->owners()->paginate();
        return self::formatPagination($restaurants);
    }

    /**
     * @param User $user
     * @return paginate
     */
    public static function getByUser(User $user): paginate
    {
        return $user->ownedRestaurants()->paginate();
    }

    /**
     * @param Invitation $invitation
     * @return array
     */
    public static function getByInvitation(Invitation $invitation): array
    {
        return $invitation->restaurant()->get()->first()->format();
    }

    /**
     * @param Reservation $reservation
     * @return array
     */
    public static function getByReservation(Reservation $reservation): array
    {
        return $reservation->restaurant()->get()->first()->format();
    }

}
