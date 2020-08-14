<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Product;

//use Your Model

/**
 * Class ProductResource.
 */
class ProductRepository
{
    /**
     * get a list of Products
     * @return LengthAwarePaginator
     */
    public static function getAll():LengthAwarePaginator
    {
        return Product::paginate();
    }

    /**
     * get A Product with id
     * @param $id
     * @return Product
     */
    public static function get($id): Product
    {
        return Product::findOrfail($id);
    }

    /**
     * get a format Product with id
     * @param $id
     * @return array
     */
    public static function show($id):array
    {
        return self::get($id)->format();
    }

    /**
     * Create a new Product
     * @param $item
     * @return Product
     */
    public static function store($item):Product
    {
        return Product::create($item->all());
    }

    /**
     * update a Product
     * @param $item
     * @param $id
     * @return array
     */
    public static function update($item, $id):array
    {
        self::get($id)->update($item->all());

        return self::show($id);
    }

    /**
     * delete a row in Database
     * @param $id
     */
    public static function delete($id)
    {
        return self::get($id)->delete();
    }
}
