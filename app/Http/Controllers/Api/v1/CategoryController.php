<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\JsonResponse;
use Lukasoppermann\Httpstatus\Httpstatuscodes as HttpStatus;

class CategoryController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->authorizeResource(Category::class);
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(app(CategoryRepository::class)->getAll(), HttpStatus::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        return response()->json(app(CategoryRepository::class)->store($request), HttpStatus::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        return response()->json(app(CategoryRepository::class)->show($category), HttpStatus::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        return response()->json(app(CategoryRepository::class)->update($request, $category),
            HttpStatus::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     * @param Category $category
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Category $category): JsonResponse
    {
        return response()->json(app(CategoryRepository::class)->delete($category), HttpStatus::HTTP_NO_CONTENT);
    }


    /**
     * @param Category $category
     * @return JsonResponse
     */
    public function getRestaurants(Category $category): JsonResponse
    {
        return response()->json(app(CategoryRepository::class)->getRestaurant($category), HttpStatus::HTTP_OK);
    }
}
