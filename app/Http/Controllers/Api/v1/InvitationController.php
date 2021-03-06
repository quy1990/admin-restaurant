<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvitationRequest;
use App\Models\Invitation;
use App\Repositories\InvitationRepository;
use Illuminate\Http\JsonResponse;
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
     * @param InvitationRequest $request
     * @return JsonResponse
     */
    public function store(InvitationRequest $request): JsonResponse
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
     * @param InvitationRequest $request
     * @param Invitation $invitation
     * @return JsonResponse
     */
    public function update(InvitationRequest $request, Invitation $invitation): JsonResponse
    {
        return response()->json(app(InvitationRepository::class)->update($request, $invitation),
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
        return response()->json(app(InvitationRepository::class)->getRestaurant($invitation), HttpStatus::HTTP_OK);
    }

    /**
     * @param Invitation $invitation
     * @return JsonResponse
     */
    public function getReservation(Invitation $invitation)
    {
        return response()->json(app(InvitationRepository::class)->getReservation($invitation), HttpStatus::HTTP_OK);
    }

    /**
     * @param Invitation $invitation
     * @return JsonResponse
     */
    public function getUser(Invitation $invitation)
    {
        return response()->json(app(InvitationRepository::class)->getUser($invitation), HttpStatus::HTTP_OK);
    }

    /**
     * @param Invitation $invitation
     * @return JsonResponse
     */
    public function getPeoples(Invitation $invitation)
    {
        return response()->json(app(InvitationRepository::class)->getPeoples($invitation), HttpStatus::HTTP_OK);
    }
}
