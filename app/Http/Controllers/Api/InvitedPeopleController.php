<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InvitedPeople;
use App\Repositories\InvitationRepository;
use App\Repositories\InvitedPeopleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lukasoppermann\Httpstatus\Httpstatuscodes as Httpstatus;

class InvitedPeopleController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
        $this->authorizeResource(InvitedPeople::class);
    }

    public function index(): JsonResponse
    {
        return response()->json(InvitedPeopleRepository::getAll($this->user), Httpstatus::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $invitedInformations = $request->invitedInformations;
        $invitedPeoples = [];
        foreach ($invitedInformations as $invitedInformation) {
            $invitedInformation['invitation_id'] = $request->invitation_id;
            $invitedInformation['user_id'] = $request->user_id;
            $invitedPeoples[] = InvitedPeopleRepository::storeAnItem($invitedInformation);
        }
        $reservation = InvitationRepository::get($request->invitation_id)->reservation;
        if ($this->user->id == $reservation->user_id) {
            return response()->json(
                ['data' => InvitedPeopleRepository::getByInvitationId($request->invitation_id)], Httpstatus::HTTP_CREATED);
        } else {
            return Response()->json('Error', 200);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param InvitedPeople $invitedPeople
     * @return JsonResponse
     */
    public function show(InvitedPeople $invitedPeople): JsonResponse
    {
        return response()->json(InvitedPeopleRepository::show($invitedPeople->id), Httpstatus::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param InvitedPeople $invitedPeople
     * @return JsonResponse
     */
    public function update(Request $request, InvitedPeople $invitedPeople): JsonResponse
    {
        return response()->json(InvitedPeopleRepository::update($request, $invitedPeople->id), Httpstatus::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @param InvitedPeople $invitedPeople
     * @return JsonResponse
     */
    public function destroy(InvitedPeople $invitedPeople): JsonResponse
    {
        return response()->json(InvitedPeopleRepository::delete($invitedPeople->id), Httpstatus::HTTP_NO_CONTENT);
    }
}
