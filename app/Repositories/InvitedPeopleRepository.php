<?php

namespace App\Repositories;

use App\Models\InvitedPeople;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class RestaurantResource.
 */
class InvitedPeopleRepository
{
    /**
     * get a list of Restaurants
     *
     * @param User $user
     *
     * @return LengthAwarePaginator
     */
    public static function getAll(User $user): LengthAwarePaginator
    {
        return InvitedPeople::where('user_id', $user->id)->paginate();
    }

    /**
     * get A InvitedPeople by id
     * @param $id
     * @return InvitedPeople
     */
    public static function get($id): InvitedPeople
    {
        return InvitedPeople::findOrfail($id);
    }

    /**
     * get a format InvitedPeople by id
     * @param int $id
     * @return array
     */
    public static function show(int $id): array
    {
        return self::get($id)->format();
    }

    /**
     * Create a new InvitedPeople
     * @param $request
     * @return array
     */
    public static function store(Request $request): array
    {
        $invitedPeople = InvitedPeople::create($request->all());
        return self::show($invitedPeople->id);
    }

    /**
     * @param array $item
     * @return array
     */
    public static function storeAnItem(array $item): array
    {
        $invitedPeople = new InvitedPeople();
        $invitedPeople->email = $item['email'];
        $invitedPeople->phone = $item['phone'];
        $invitedPeople->invitation_id = $item['invitation_id'];
        $invitedPeople->user_id = $item['user_id'];
        $invitedPeople->save();
        return self::show($invitedPeople->id);
    }

    /**
     * update a InvitedPeople
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
     * @param $id
     * @return bool|null
     * @throws \Exception
     */
    public static function delete($id)
    {
        return self::get($id)->delete();
    }

    /**
     * @param int $invitation_id
     * @return array
     */
    public static function getByInvitationId(int $invitation_id)
    {
        return InvitationRepository::get($invitation_id)->invitedPeoples()->get()->map(function ($item) {
            return $item->format();
        });
    }
}
