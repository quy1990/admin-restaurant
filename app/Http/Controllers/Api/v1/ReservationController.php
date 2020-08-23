<?php
namespace App\Http\Controllers\Api\v1;

use App\Events\CustomerReserveEvent;
use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Reservation;
use App\Models\User as Customer;
use App\Repositories\InvitationRepository;
use App\Repositories\PeopleRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\RestaurantRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
            ->json(ReservationRepository::getAll(), HttpStatus::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $customer = Customer::find(auth()->user()->id);
        return response()->json(ReservationRepository::store($request, $customer)->format(),
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
            ->json(ReservationRepository::show($reservation), HttpStatus::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function update(Request $request, Reservation $reservation): JsonResponse
    {
        event(new CustomerReserveEvent($reservation));

        return response()
            ->json(ReservationRepository::update($request, $reservation->id), HttpStatus::HTTP_OK);
    }

    /**
    * Remove the specified resource from storage.
     *
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function destroy(Reservation $reservation): JsonResponse
    {
        ReservationRepository::delete($reservation);

        return response()->json([], HttpStatus::HTTP_NO_CONTENT);
    }

    /**
     *
     * @param Invitation $invitation
     * @return JsonResponse
     */
    public function getByInvitation(Invitation $invitation): JsonResponse
    {
        return response()->json(ReservationRepository::getByInvitation($invitation), HttpStatus::HTTP_OK);
    }

    /**
     *
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function getRestaurant(Reservation $reservation): JsonResponse
    {
        return response()->json(RestaurantRepository::getByReservation($reservation), HttpStatus::HTTP_OK);
    }

    /**
     *
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function getUser(Reservation $reservation): JsonResponse
    {
        return response()->json(UserRepository::getByReservation($reservation), HttpStatus::HTTP_OK);
    }

    /**
     *
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function getInvitations(Reservation $reservation): JsonResponse
    {
        return response()->json(InvitationRepository::getByReservation($reservation), HttpStatus::HTTP_OK);
    }

    /**
     *
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function getPeoples(Reservation $reservation): JsonResponse
    {
        return response()->json(PeopleRepository::getByReservation($reservation), HttpStatus::HTTP_OK);
    }
}
