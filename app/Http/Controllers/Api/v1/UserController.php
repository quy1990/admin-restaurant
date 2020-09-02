<?php
namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Repositories\RestaurantRepository;
use App\Repositories\UserRepository;
use App\User;

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
        return response()->json(app(UserRepository::class)->getReservations($user), 200);
    }
    /**
     * @param User $user
     * @return mixed
     */
    public function getInvitations(User $user)
    {
        return response()->json(app(UserRepository::class)->getInvitations($user), 200);
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
