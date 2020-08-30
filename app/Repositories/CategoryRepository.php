<?php

namespace App\Repositories;

use App\Models\Restaurant;
use App\Models\Category;
use App\Repositories\Traits\FormatPaginationTrait;
use App\Repositories\Traits\GeneralFunctionTrait;
use Illuminate\Support\Collection;

/**
 * Class UserResource.
 */
class CategoryRepository
{
    use FormatPaginationTrait, GeneralFunctionTrait;

    /**
     * get a list of Restaurants
     * @return Collection
     */
    public function getAll(): Collection
    {
        return self::formatPagination(Category::paginate());
    }

    /**
     * get A User with id
     * @param $id
     * @return Category
     */
    public function get($id): Category
    {
        return Category::findOrFail($id);
    }

    /**
     * Create a new Invitation
     * @param $request
     * @return array
     */
    public function store($request): array
    {
        return Category::create($request->all())->format();
    }

    /**
     * @param Restaurant $restaurant
     * @return Collection
     */
    public function getByRestaurant(Restaurant $restaurant): Collection
    {
        return self::formatPagination($restaurant->categories()->paginate());
    }

    /**
     * @param Category $category
     * @return Collection
     */
    public function getRestaurant(Category $category): Collection
    {
        return self::formatPagination($category->restaurants()->paginate());
    }
}
