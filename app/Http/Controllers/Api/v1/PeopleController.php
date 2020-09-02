<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\People;
use App\Repositories\PeopleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lukasoppermann\Httpstatus\Httpstatuscodes as HttpStatus;

class PeopleController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->authorizeResource(People::class);
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(app(PeopleRepository::class)->getAll(), Httpstatus::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = array();
        $peoples = $request->get("peoples") ?? "";
        if (!empty($peoples)) {
            foreach ($peoples as $people) {
                $people['user_id'] = $request->get("user_id");
                $people['restaurant_id'] = $request->get("restaurant_id");
                $people['invitation_id'] = $request->get("invitation_id");
                $people['reservation_id'] = $request->get("reservation_id");
                $data[] = app(PeopleRepository::class)->store($people);
            }
            return response()->json($data, Httpstatus::HTTP_CREATED);
        }
        return response()->json("", Httpstatus::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Display the specified resource.
     *
     * @param People $people
     * @return JsonResponse
     */
    public function show(People $people): JsonResponse
    {
        return response()->json(app(PeopleRepository::class)->show($people), Httpstatus::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
//    public function update(Request $request, int $id): JsonResponse
//    {
//        return response()->json("Can not update!!!", Httpstatus::HTTP_OK);
//    }

    /**
     * Remove the specified resource from storage.
     * @param People $people
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(People $people): JsonResponse
    {
        return response()->json(app(PeopleRepository::class)->delete($people), Httpstatus::HTTP_NO_CONTENT);
    }
}
