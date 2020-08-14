<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 */
class Restaurant extends Model
{
    protected $fillable = ["name", "address", "email", "phone", "seat_number"];

    protected $hidden = array('created_at', 'updated_at');

    public function format(){
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'address'     => $this->address,
            'email'       => $this->email ?? "",
            'phone'       => $this->phone ?? "",
            'seat_number' => (string)$this->seat_number ?? 0,
        ];
    }

    public function getShortName()
    {
        return $this->name;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'reservations')
            ->withPivot('number_people', 'booking_time');
    }

    public function owners()
    {
        return $this->belongsToMany(User::class, 'restaurant_owner');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($restaurant) {
            $restaurant->reservations()->each(function ($item) {
                $item->delete();
            });
        });
    }

}
