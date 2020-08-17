<?php

namespace App\Repositories;

use App\Models\People;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Invitation;
use phpDocumentor\Reflection\Types\Self_;

/**
 * Class RestaurantResource.
 */
class PeopleRepository
{
    /**
     * get a list of Restaurants
     *
     * @param User|null $user
     * @return LengthAwarePaginator
     */
    public static function getAll(?User $user): LengthAwarePaginator
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
     * @param People $invitedPeople
     * @return array
     */
    public static function show(People $invitedPeople): array
    {
        return $invitedPeople->format();
    }

    /**
     * Create a new People
     * @param $request
     * @return array
     */
    public static function store(Request $request): array
    {
        $invitedPeople = People::create($request->all());
        return self::show($invitedPeople->id);
    }

    /**
     * @param array $item
     * @return array
     */
    public static function storeAnItem(array $item): array
    {
        $invitedPeople = new People();
        $invitedPeople->email = $item['email'];
        $invitedPeople->phone = $item['phone'];
        $invitedPeople->invitation_id = $item['invitation_id'];
        $invitedPeople->user_id = $item['user_id'];
        $invitedPeople->save();
        return self::show($invitedPeople->id);
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
        return self::show($id);
    }

    /**
     * delete a row in Database
     * @param People $invitedPeople
     * @return bool|null
     * @throws \Exception
     */
    public static function delete(People $invitedPeople)
    {
        return $invitedPeople->delete();
    }

    /**
     * @param Invitation $invitation
     * @return
     */
    public static function getByInvitation(Invitation $invitation)
    {
        return $invitation->invitedPeoples()->paginate();
    }
}
