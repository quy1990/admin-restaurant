<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Models\Image;
use App\Repositories\ImageRepository;
use Illuminate\Http\JsonResponse;
use Lukasoppermann\Httpstatus\Httpstatuscodes as HttpStatus;

class ImageController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->authorizeResource(Image::class);
    }

    public function index(): JsonResponse
    {
        return response()->json(app(ImageRepository::class)->getAll(), HttpStatus::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * @param ImageRequest $request
     * @return JsonResponse
     */
    public function store(ImageRequest $request): JsonResponse
    {
        return response()->json(app(ImageRepository::class)->store($request), HttpStatus::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Image $image
     * @return JsonResponse
     */
    public function show(Image $image): JsonResponse
    {
        return response()->json(app(ImageRepository::class)->show($image), HttpStatus::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ImageRequest $request
     * @param Image $image
     * @return JsonResponse
     */
    public function update(ImageRequest $request, Image $image): JsonResponse
    {
        return response()->json(app(ImageRepository::class)->update($request, $image),
            HttpStatus::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @param Image $image
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Image $image): JsonResponse
    {
        return response()->json(app(ImageRepository::class)->delete($image), HttpStatus::HTTP_NO_CONTENT);
    }

    /**
     * @param Image $image
     * @return JsonResponse
     */
    public function getRestaurants(Image $image): JsonResponse
    {
        return response()->json(app(ImageRepository::class)->getRestaurants($image), HttpStatus::HTTP_OK);
    }
}
