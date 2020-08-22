<?php

namespace App\Repositories;

use App\Models\Invitation;
use App\Models\People;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as paginate;
use Illuminate\Support\Facades\Redis;

/**
 * Class RestaurantResource.
 */
class PeopleRepository
{
    /**
     * get a list of Restaurants
     *
     * @param User|null $user
     * @return paginate
     */
    public static function getAll(?User $user): paginate
    {
        return People::paginate();
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
        $key = "PeopleRepository_Show_" . $people->id;
        if (!Redis::hgetall($key)) {
            Redis::hmset($key, $people->format());
        }
        return Redis::hgetall($key);
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
        self::get($id)->update($request->all());
        $key = "PeopleRepository_Show_" . $id;
        Redis::hmset($key, self::get($id)->format());
        return Redis::hgetall($key);
    }

    /**
     * delete a row in Database
     * @param People $people
     * @return bool|null
     * @throws \Exception
     */
    public static function delete(People $people)
    {
        $key = 'PeopleRepository_Show_' . $people->id;
        Redis::del($key);
        return $people->delete();
    }

    /**
     * @param Invitation $invitation
     * @return
     */
    public static function getByInvitation(Invitation $invitation)
    {
        return $invitation->peoples()->paginate();
    }

    /**
     * @param Reservation $reservation
     * @return
     */
    public static function getByReservation(Reservation $reservation)
    {
        return $reservation->peoples()->paginate();
    }
}
