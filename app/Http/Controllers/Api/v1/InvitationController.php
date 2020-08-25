<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Repositories\InvitationRepository;
use App\Repositories\PeopleRepository;
use App\Repositories\ReservationRepository;
use App\Repositories\RestaurantRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lukasoppermann\Httpstatus\Httpstatuscodes as HttpStatus;

class InvitationController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->authorizeResource(Invitation::class);
    }

    public function index(): JsonResponse
    {
        return response()->json(app(InvitationRepository::class)->getAll(), HttpStatus::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return response()->json(app(InvitationRepository::class)->store($request), HttpStatus::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Invitation $invitation
     * @return JsonResponse
     */
    public function show(Invitation $invitation): JsonResponse
    {
        return response()->json(app(InvitationRepository::class)->show($invitation), HttpStatus::HTTP_OK);
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
        return response()->json(app(InvitationRepository::class)->update($request, $invitation->id),
            HttpStatus::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @param Invitation $invitation
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Invitation $invitation): JsonResponse
    {
        return response()->json(app(InvitationRepository::class)->delete($invitation), HttpStatus::HTTP_NO_CONTENT);
    }

    /**
     * @param Invitation $invitation
     * @return JsonResponse
     */
    public function getRestaurant(Invitation $invitation)
    {
        return response()->json(app(RestaurantRepository::class)->getByInvitation($invitation), HttpStatus::HTTP_OK);

    }

    /**
     * @param Invitation $invitation
     * @return JsonResponse
     */
    public function getReservation(Invitation $invitation)
    {
        return response()->json(app(ReservationRepository::class)->getByInvitation($invitation), HttpStatus::HTTP_OK);
    }

    /**
     * @param Invitation $invitation
     * @return JsonResponse
     */
    public function getUser(Invitation $invitation)
    {
        return response()->json(app(UserRepository::class)->getByInvitation($invitation), HttpStatus::HTTP_OK);
    }

    /**
     * @param Invitation $invitation
     * @return JsonResponse
     */
    public function getPeoples(Invitation $invitation)
    {
        return response()->json(app(PeopleRepository::class)->getByInvitation($invitation), HttpStatus::HTTP_OK);
    }
}
