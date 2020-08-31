<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static paginate()
 * @method static findOrFail($id)
 */
class Comment extends Model
{
    protected $fillable = ['user_id', 'body', 'commentable_id', 'commentable_type'];

    public function format()
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user_id' => $this->user_id,
        ];
    }

    /**
     * Get the owning commentable model.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
