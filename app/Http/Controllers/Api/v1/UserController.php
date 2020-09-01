<?php
namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\User;
use App\Repositories\InvitationRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\RestaurantRepository;

class UserController extends Controller
{

    protected $user;

    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function getRestaurants(User $user)
    {
        return response()->json(app(RestaurantRepository::class)->getByUser($user), 200);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function getReservations(User $user)
    {
        return response()->json(app(ReservationRepository::class)->getByUser($user), 200);
    }
    /**
     * @param User $user
     * @return mixed
     */
    public function getInvitations(User $user)
    {
        return response()->json(app(InvitationRepository::class)->getByUser($user), 200);
    }
    /**
     * @param User $user
     * @return mixed
     */
    public function getPeoples(User $user)
    {
        return response()->json(app(UserRepository::class)->getPeoples($user), 200);
    }
}
