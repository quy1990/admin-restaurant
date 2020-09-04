<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use App\Repositories\TagRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lukasoppermann\Httpstatus\Httpstatuscodes as HttpStatus;

class TagController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->authorizeResource(Tag::class);
    }

    public function index(): JsonResponse
    {
        return response()->json(app(TagRepository::class)->getAll(), HttpStatus::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * @param TagRequest $request
     * @return JsonResponse
     */
    public function store(TagRequest $request): JsonResponse
    {
        return response()->json(app(TagRepository::class)->store($request), HttpStatus::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Tag $tag
     * @return JsonResponse
     */
    public function show(Tag $tag): JsonResponse
    {
        return response()->json(app(TagRepository::class)->show($tag), HttpStatus::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TagRequest $request
     * @param Tag $tag
     * @return JsonResponse
     */
    public function update(TagRequest $request, Tag $tag): JsonResponse
    {
        return response()->json(app(TagRepository::class)->update($request, $tag->id),
            HttpStatus::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @param Tag $tag
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Tag $tag): JsonResponse
    {
        return response()->json(app(TagRepository::class)->delete($tag), HttpStatus::HTTP_NO_CONTENT);
    }

    /**
     * @param $tag
     * @return JsonResponse
     */
    public function getRestaurants(Tag $tag): JsonResponse
    {
        return response()->json(app(TagRepository::class)->getRestaurants($tag), HttpStatus::HTTP_OK);
    }
}
