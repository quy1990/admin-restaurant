<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static findOrFail($id)
 * @method static paginate()
 * @method static create($all)
 */
class Category extends Model
{

    public function format()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }


    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'category_restaurant');
    }
}
