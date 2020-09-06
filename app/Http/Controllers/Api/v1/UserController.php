<?php
namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
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
    public function getVisitedRestaurants(User $user)
    {
        return response()->json(app(UserRepository::class)->getVisitedRestaurants($user), 200);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function getOwnedRestaurants(User $user)
    {
        return response()->json(app(UserRepository::class)->ownedRestaurants($user), 200);
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
