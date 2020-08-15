<?php

namespace App\Repositories;

use App\Models\Invitation;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

//use Your Model

/**
 * Class RestaurantResource.
 */
class InvitationRepository
{
    /**
     * get a list of Restaurants
     * @return LengthAwarePaginator
     */
    public static function getAll():LengthAwarePaginator
    {
        return Invitation::paginate();
    }

    /**
     * get A Invitation with id
     * @param $id
     * @return Invitation
     */
    public static function get($id): Invitation
    {
        return Invitation::findOrfail($id);
    }

    /**
     * get a format Invitation with id
     * @param $id
     * @return array
     */
    public static function show($id):array
    {
        return self::get($id)->format();
    }

    /**
     * Create a new Invitation
     * @param $request
     * @return Invitation
     */
    public static function store($request): Invitation
    {
        return Invitation::create($request->all());
    }

    /**
     * update a Invitation
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
     * @param Reservation $reservation
     */
    public static function getByReservation(Reservation $reservation)
    {
        return $reservation->invitations()->paginate();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public static function getByUser(User $user)
    {
        return $user->invitations()->paginate();
    }
}
