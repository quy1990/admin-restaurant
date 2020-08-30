<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Image;
use App\Repositories\Traits\FormatPaginationTrait;
use App\Repositories\Traits\GeneralFunctionTrait;
use Illuminate\Support\Collection;

/**
 * Class UserResource.
 */
class ImageRepository
{
    use FormatPaginationTrait, GeneralFunctionTrait;

    /**
     * get a list of Restaurants
     * @return Collection
     */
    public function getAll(): Collection
    {
        return self::formatPagination(Image::paginate());
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
     * @param Image $image
     * @return Collection
     */
    public function getRestaurants(Image $image): Collection
    {
        return self::formatPagination($image->restaurants->paginate());
    }

}
