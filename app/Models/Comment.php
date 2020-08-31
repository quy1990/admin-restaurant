<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static paginate()
 * @method static findOrFail($id)
 */
class Comment extends Model
{
    public function format()
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
        ];
    }

    /**
     * Get the owning commentable model.
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}
