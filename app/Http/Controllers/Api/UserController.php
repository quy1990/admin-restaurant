<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use App\Repositories\RestaurantRepository;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * @return mixed
     */
    public function getRestaurants()
    {
        return response()->json(RestaurantRepository::getByUser($this->user), 200);
    }

    /**
     * @return mixed
     */
    public function getReservations()
    {
        return response()->json(ReservationRepository::getByUser($this->user), 200);
    }
}
