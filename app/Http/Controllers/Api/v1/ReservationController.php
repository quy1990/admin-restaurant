<?php
namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use Illuminate\Http\JsonResponse;
use Lukasoppermann\Httpstatus\Httpstatuscodes as HttpStatus;

class ReservationController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->authorizeResource(Reservation::class);
    }

    /**
     * show all with paginate
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()
            ->json(app(ReservationRepository::class)->getAll(), HttpStatus::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ReservationRequest $request
     * @return JsonResponse
     */
    public function store(ReservationRequest $request): JsonResponse
    {
        return response()->json(app(ReservationRepository::class)->store($request, auth()->user()),
            HttpStatus::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function show(Reservation $reservation): JsonResponse
    {
        return response()
            ->json(app(ReservationRepository::class)->show($reservation), HttpStatus::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ReservationRequest $request
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function update(ReservationRequest $request, Reservation $reservation): JsonResponse
    {
        return response()->json(app(ReservationRepository::class)->update($request, $reservation), HttpStatus::HTTP_OK);
    }

    /**
    * Remove the specified resource from storage.
     *
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function destroy(Reservation $reservation): JsonResponse
    {
        app(ReservationRepository::class)->delete($reservation);

        return response()->json([], HttpStatus::HTTP_NO_CONTENT);
    }

    /**
     *
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function getRestaurant(Reservation $reservation): JsonResponse
    {
        return response()->json(app(ReservationRepository::class)->getRestaurant($reservation), HttpStatus::HTTP_OK);
    }

    /**
     *
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function getUser(Reservation $reservation): JsonResponse
    {
        return response()->json(app(ReservationRepository::class)->getUser($reservation), HttpStatus::HTTP_OK);
    }

    /**
     *
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function getInvitations(Reservation $reservation): JsonResponse
    {
        return response()->json(app(ReservationRepository::class)->getInvitations($reservation), HttpStatus::HTTP_OK);
    }

    /**
     *
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function getPeoples(Reservation $reservation): JsonResponse
    {
        return response()->json(app(ReservationRepository::class)->getPeoples($reservation), HttpStatus::HTTP_OK);
    }
}
