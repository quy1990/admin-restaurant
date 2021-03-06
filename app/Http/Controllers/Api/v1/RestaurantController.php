<?php
namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantRequest;
use App\Models\Restaurant;
use App\Repositories\RestaurantRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lukasoppermann\Httpstatus\Httpstatuscodes as HttpStatus;

class RestaurantController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->authorizeResource(Restaurant::class);
    }

    /**
     * get a list of Restaurants
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(app(RestaurantRepository::class)->getAll(), HttpStatus::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * @param RestaurantRequest $request
     * @return JsonResponse
     */
    public function store(RestaurantRequest $request): JsonResponse
    {
        return response()->json(app(RestaurantRepository::class)->store($request), HttpStatus::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function show(Restaurant $restaurant): JsonResponse
    {
        return response()->json(app(RestaurantRepository::class)->show($restaurant), HttpStatus::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RestaurantRequest $request
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function update(RestaurantRequest $request, Restaurant $restaurant): JsonResponse
    {
        return response()
            ->json(app(RestaurantRepository::class)->update($request, $restaurant), HttpStatus::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Restaurant $restaurant
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Restaurant $restaurant): JsonResponse
    {
        return response()->json(app(RestaurantRepository::class)->delete($restaurant), HttpStatus::HTTP_NO_CONTENT);
    }

    /**
     * get all Reservations of this restaurant
     *
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function getReservations(Restaurant $restaurant): JsonResponse
    {
        return response()->json(app(RestaurantRepository::class)->getReservations($restaurant), HttpStatus::HTTP_OK);
    }

    /**
     * get all Reservations of this restaurant
     *
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function getOwners(Restaurant $restaurant): JsonResponse
    {
        return response()->json(app(RestaurantRepository::class)->getOwners($restaurant), HttpStatus::HTTP_OK);
    }

    /**
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function getCategories(Restaurant $restaurant): JsonResponse
    {
        return response()->json(app(RestaurantRepository::class)->getCategories($restaurant), HttpStatus::HTTP_OK);
    }

    /**
     * get all Reservations of this restaurant
     *
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function getImages(Restaurant $restaurant): JsonResponse
    {
        return response()->json(app(RestaurantRepository::class)->getImages($restaurant), HttpStatus::HTTP_OK);
    }

    /**
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function getTags(Restaurant $restaurant): JsonResponse
    {
        return response()->json(app(RestaurantRepository::class)->getTags($restaurant), HttpStatus::HTTP_OK);
    }

    /**
     * @param Restaurant $restaurant
     * @return JsonResponse
     */
    public function getComments(Restaurant $restaurant): JsonResponse
    {
        return response()->json(app(RestaurantRepository::class)->getComments($restaurant), HttpStatus::HTTP_OK);
    }

    public function search(Request $request)
    {
        return response()->json(app(RestaurantRepository::class)->search($request->get('q')), HttpStatus::HTTP_OK);
    }
}
