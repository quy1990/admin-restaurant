<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static paginate()
 * @method static findOrFail($id)
 */
class Invitation extends Model
{
    protected $fillable = ['user_id', 'reservation_id', 'restaurant_id', 'message'];

    public function format()
    {
        return [
            'id'             => $this->id,
            'user_id'        => (string)$this->user_id,
            'restaurant_id'  => (string)$this->restaurant_id,
            'reservation_id' => (string)$this->reservation_id,
            'message'        => $this->message,
        ];
    }

    public function peoples()
    {
        return $this->hasMany(People::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($invitation) {
            $invitation->peoples()->each(function ($item) {
                $item->delete();
            });
        });
    }
}
