<?php

namespace App\Repositories;

use App\Models\Invitation;
use App\Models\People;
use App\Models\Reservation;
use App\Models\User;
use App\Repositories\Traits\FormatPaginationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class RestaurantResource.
 */
class PeopleRepository
{
    use FormatPaginationTrait;

    /**
     * get a list of Restaurants
     *
     * @param User|null $user
     * @return Collection
     */
    public static function getAll(?User $user): Collection
    {
        $peoples = People::paginate();
        return self::formatPagination($peoples);

    }

    /**
     * get A People by id
     * @param $id
     * @return People
     */
    public static function get($id): People
    {
        return People::findOrfail($id);
    }

    /**
     * get a format People by id
     * @param People $people
     * @return array
     */
    public static function show(People $people): array
    {
        return $people->format();
    }

    /**
     * Create a new People
     * @param $request
     * @return array
     */
    public static function store(Request $request): array
    {
        $people = People::create($request->all());
        return self::show($people->id);
    }

    /**
     * @param array $item
     * @return array
     */
    public static function storeAnItem(array $item): array
    {
        $people = new People();
        $people->email = $item['email'];
        $people->phone = $item['phone'];
        $people->invitation_id = $item['invitation_id'];
        $people->user_id = $item['user_id'];
        $people->restaurant_id = $item['restaurant_id'];
        $people->reservation_id = $item['reservation_id'];
        $people->save();
        return self::show($people->id);
    }

    /**
     * update a People
     * @param $request
     * @param $id
     * @return array
     */
    public static function update($request, $id): array
    {
        return self::get($id)->update($request->all())->format();
    }

    /**
     * delete a row in Database
     * @param People $people
     * @return bool|null
     * @throws \Exception
     */
    public static function delete(People $people)
    {
        return $people->delete();
    }

    /**
     * @param Invitation $invitation
     * @return Collection
     */
    public static function getByInvitation(Invitation $invitation): Collection
    {
        $peoples = $invitation->peoples()->paginate();

        return self::formatPagination($peoples);
    }

    /**
     * @param Reservation $reservation
     * @return Collection
     */
    public static function getByReservation(Reservation $reservation): Collection
    {
        $peoples = $reservation->peoples()->paginate();

        return self::formatPagination($peoples);
    }
}
