<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static paginate()
 * @property mixed restaurants
 */
class Image extends Model
{
    public function format()
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
        ];
    }

    /**
     * Get the owning imageable model.
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
