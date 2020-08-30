<?php

namespace App\Repositories;

use App\Models\Restaurant;
use App\Models\Tag;
use App\Repositories\Traits\FormatPaginationTrait;
use App\Repositories\Traits\GeneralFunctionTrait;
use Illuminate\Support\Collection;

/**
 * Class UserResource.
 */
class TagRepository
{
    use FormatPaginationTrait, GeneralFunctionTrait;

    /**
     * get a list of Restaurants
     * @return Collection
     */
    public function getAll(): Collection
    {
        return self::formatPagination(Tag::paginate());
    }

    /**
     * get A User with id
     * @param $id
     * @return Tag
     */
    public function get($id): Tag
    {
        return Tag::findOrFail($id);
    }

    /**
     * Create a new Invitation
     * @param $request
     * @return array
     */
    public function store($request): array
    {
        return Tag::create($request->all())->format();
    }

    /**
     * @param Restaurant $restaurant
     * @return Collection
     */
    public function getByRestaurant(Restaurant $restaurant): Collection
    {
        return self::formatPagination($restaurant->tags()->paginate());
    }

    /**
     * @param Tag $tag
     * @return Collection
     */
    public function getRestaurants(Tag $tag): Collection
    {
        return self::formatPagination($tag->restaurants->paginate());
    }
}
