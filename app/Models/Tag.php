<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static paginate()
 * @method static findOrFail($id)
 * @method static create($all)
 * @property mixed restaurants
 */
class Tag extends Model
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
        return $this->morphedByMany(Restaurant::class, 'taggable');
    }
}
