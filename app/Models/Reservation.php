<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 */
class Reservation extends Model
{
    protected $fillable = ['restaurant_id', 'user_id', 'number_people', 'booking_time'];

    public function format(){
        return [
            'id'                => $this->id,
            'restaurant_id'     => $this->restaurant_id,
            'user_id'           => $this->user_id,
            'number_people'     => (string)$this->number_people,
            'booking_time'      => $this->booking_time,
        ];
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function peoples()
    {
        return $this->hasMany(People::class);
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($reservation) {
            $reservation->invitations()->each(function ($item) {
                $item->delete();
            });
        });
    }

}
