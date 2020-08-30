<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static paginate()
 * @method static findOrFail($id)
 */
class Comment extends Model
{
    /**
     * Get the owning commentable model.
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}
