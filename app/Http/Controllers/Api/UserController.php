<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\User;
use App\Repositories\ReservationRepository;
use App\Repositories\RestaurantRepository;
use App\Repositories\InvitationRepository;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    protected $user;

    public function __construct()
    {
        //$this->user = Auth::user();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function getRestaurant(User $user)
    {
        return response()->json(RestaurantRepository::getByUser($user), 200);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function getReservation(User $user)
    {
        return response()->json(ReservationRepository::getByUser($user), 200);
    }
    /**
     * @param User $user
     * @return mixed
     */
    public function getInvitation(User $user)
    {
        return response()->json(InvitationRepository::getByUser($user), 200);
    }
}
