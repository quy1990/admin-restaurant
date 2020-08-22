<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\People;
use App\Repositories\InvitationRepository;
use App\Repositories\PeopleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lukasoppermann\Httpstatus\Httpstatuscodes as HttpStatus;

class PeopleController extends Controller
{
    protected $user;

    public function __construct()
    {
//        $this->user = Auth::user();
        $this->authorizeResource(People::class);
    }

    public function index(): JsonResponse
    {
        return response()->json(PeopleRepository::getAll($this->user), Httpstatus::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $invitedInformations = $request->invitedInformations;
        $peoples = [];
        foreach ($invitedInformations as $invitedInformation) {
            $invitedInformation['invitation_id'] = $request->invitation_id;
            $invitedInformation['user_id'] = $request->user_id;
            $peoples[] = PeopleRepository::storeAnItem($invitedInformation);
        }
        $reservation = InvitationRepository::get($request->invitation_id)->reservation;
        if ($this->user->id == $reservation->user_id) {
            return response()->json(
                ['data' => PeopleRepository::getByInvitationId($request->invitation_id)], Httpstatus::HTTP_CREATED);
        } else {
            return Response()->json('Error', 200);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param People $people
     * @return JsonResponse
     */
    public function show(People $people): JsonResponse
    {
        return response()->json(PeopleRepository::show($people), Httpstatus::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param People $people
     * @return JsonResponse
     */
    public function update(Request $request, People $people): JsonResponse
    {
        return response()->json(PeopleRepository::update($request, $people->id), Httpstatus::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @param People $people
     * @return JsonResponse
     */
    public function destroy(People $people): JsonResponse
    {
        return response()->json(PeopleRepository::delete($people->id), Httpstatus::HTTP_NO_CONTENT);
    }
}
