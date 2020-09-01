<?php

namespace App\Repositories;

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
     * Create a new Invitation
     * @param $request
     * @return array
     */
    public function store($request): array
    {
        return Image::create($request->all())->format();
    }

    /**
     * get A User with id
     * @param $id
     * @return Image
     */
    public function get($id): Image
    {
        return Image::findOrFail($id);
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
