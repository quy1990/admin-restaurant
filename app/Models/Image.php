<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static paginate()
 * @method static create($all)
 * @property mixed restaurants
 */
class Image extends Model
{
    protected $fillable = ['url', 'imageable_id', 'imageable_type'];

    public $timestamps = false;

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
