<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Repositories\RestaurantRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lukasoppermann\Httpstatus\Httpstatuscodes as Httpstatus;

class RestaurantController extends Controller
{
    protected $user;

    public function __construct()
    {
//        $this->user = Auth::user();
        $this->authorizeResource(Restaurant::class);
    }

    /**
     * get a list of Restaurants
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()
            ->json(RestaurantRepository::getAll($request), Httpstatus::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return response()->json(RestaurantRepository::store($request, $this->user)->format(), Httpstatus::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function show(Restaurant $restaurant): JsonResponse
    {
        return response()->json(RestaurantRepository::show($restaurant->id), Httpstatus::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function update(Request $request, Restaurant $restaurant): JsonResponse
    {
        return response()
            ->json(RestaurantRepository::update($request, $restaurant->id), Httpstatus::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function destroy(Restaurant $restaurant): JsonResponse
    {
        return response()->json(RestaurantRepository::delete($restaurant), Httpstatus::HTTP_NO_CONTENT);
    }

    /**
     * get all Reservations of this restaurant
     *
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function getReservations(Restaurant $restaurant): JsonResponse
    {
        return response()->json(RestaurantRepository::getReservations($restaurant), Httpstatus::HTTP_OK);
    }

    /**
     * get all Reservations of this restaurant
     *
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function getInvitations(Restaurant $restaurant): JsonResponse
    {
        return response()->json(RestaurantRepository::getReservations($restaurant), Httpstatus::HTTP_OK);
    }

    /**
     * get all Reservations of this restaurant
     *
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function getOwners(Restaurant $restaurant): JsonResponse
    {
        return response()->json(RestaurantRepository::getOwners($restaurant), Httpstatus::HTTP_OK);
    }

}
