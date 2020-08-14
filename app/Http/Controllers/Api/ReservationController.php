<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Repositories\ReservationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lukasoppermann\Httpstatus\Httpstatuscodes as Httpstatus;

class ReservationController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
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
            ->json(ReservationRepository::getAll(), Httpstatus::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return response()->json(ReservationRepository::store($request, $this->user)->format(), Httpstatus::HTTP_CREATED);
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
            ->json(ReservationRepository::show($reservation->id), Httpstatus::HTTP_OK);
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
        return response()
            ->json(ReservationRepository::update($request, $reservation->id), Httpstatus::HTTP_OK);
    }

    /**
    * Remove the specified resource from storage.
     *
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function destroy(Reservation $reservation):JsonResponse
    {
        ReservationRepository::delete($reservation);

        return response()->json([], Httpstatus::HTTP_NO_CONTENT);
    }
}
