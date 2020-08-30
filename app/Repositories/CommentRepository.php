<?php

namespace App\Repositories;

use App\Models\Restaurant;
use App\Models\Comment;
use App\Repositories\Traits\FormatPaginationTrait;
use App\Repositories\Traits\GeneralFunctionTrait;
use Illuminate\Support\Collection;

/**
 * Class UserResource.
 */
class CommentRepository
{
    use FormatPaginationTrait, GeneralFunctionTrait;

    /**
     * get a list of Restaurants
     * @return Collection
     */
    public function getAll(): Collection
    {
        return self::formatPagination(Comment::paginate());
    }


    /**
     * Create a new Invitation
     * @param $request
     * @return array
     */
    public function store($request): array
    {
        return $this->user->comments()->create($request->all())->format();
    }

    /**
     * get A User with id
     * @param $id
     * @return Comment
     */
    public function get($id): Comment
    {
        return Comment::findOrFail($id);
    }

    /**
     * @param Restaurant $restaurant
     * @return Collection
     */
    public function getByRestaurant(Restaurant $restaurant): Collection
    {
        return self::formatPagination($restaurant->comments()->paginate());
    }
}
