<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\People;
use App\Repositories\InvitationRepository;
use App\Repositories\PeopleRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\RestaurantRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lukasoppermann\Httpstatus\Httpstatuscodes as Httpstatus;

class InvitationController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->authorizeResource(Invitation::class);
    }

    public function index(): JsonResponse
    {
        return response()->json(InvitationRepository::getAll(), Httpstatus::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return response()->json(InvitationRepository::store($request)->format(), Httpstatus::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Invitation $invitation
     * @return JsonResponse
     */
    public function show(Invitation $invitation): JsonResponse
    {
        return response()->json(InvitationRepository::show($invitation->id), Httpstatus::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Invitation $invitation
     * @return JsonResponse
     */
    public function update(Request $request, Invitation $invitation): JsonResponse
    {
        return response()->json(InvitationRepository::update($request, $invitation->id), Httpstatus::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @param Invitation $invitation
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Invitation $invitation): JsonResponse
    {
        return response()->json(InvitationRepository::delete($invitation), Httpstatus::HTTP_NO_CONTENT);
    }

    /**
     * @param Invitation $invitation
     * @return JsonResponse
     */
    public function getRestaurant(Invitation $invitation)
    {
        return response()->json(RestaurantRepository::getByInvitation($invitation), Httpstatus::HTTP_OK);

    }

    /**
     * @param Invitation $invitation
     * @return JsonResponse
     */
    public function getReservation(Invitation $invitation)
    {
        return response()->json(ReservationRepository::getByInvitation($invitation), Httpstatus::HTTP_OK);
    }

    /**
     * @param Invitation $invitation
     * @return JsonResponse
     */
    public function getUser(Invitation $invitation)
    {
        return response()->json(UserRepository::getByInvitation($invitation), Httpstatus::HTTP_OK);
    }

    /**
     * @param Invitation $invitation
     * @return JsonResponse
     */
    public function getPeoples(Invitation $invitation)
    {
        return response()->json(PeopleRepository::getByInvitation($invitation), Httpstatus::HTTP_OK);
    }
}
