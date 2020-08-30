<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static paginate()
 * @property mixed restaurants
 */
class Image extends Model
{
    /**
     * Get the owning imageable model.
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
