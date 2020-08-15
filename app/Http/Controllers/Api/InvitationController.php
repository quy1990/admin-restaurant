<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\InvitedPeople;
use App\Repositories\InvitationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lukasoppermann\Httpstatus\Httpstatuscodes as Httpstatus;

class InvitationController extends Controller
{
    protected $user;

    public function __construct()
    {
        //$this->user = Auth::user();
        //$this->authorizeResource(InvitedPeople::class);
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
     */
    public function destroy(Invitation $invitation): JsonResponse
    {
        return response()->json(InvitationRepository::delete($invitation->id), Httpstatus::HTTP_NO_CONTENT);
    }
}
