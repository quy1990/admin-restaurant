<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static paginate()
 * @method static findOrFail($id)
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
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_restaurant');
    }

    /**
     * Get the post's image.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Get all of the video's comments.
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getShortName()
    {
        return $this->name;
    }

    public function getFullName()
    {
        return $this->name;
    }

    public function getNumberBookedSeatsInNextWeek()
    {
        $start_time = date('Y-m-d');
        $to = date('Y-m-d', strtotime("+1 week"));
        return $this->reservations()
            ->whereBetween('booking_time', [$start_time, $to])
            ->sum('number_people');
    }

    public function getPercentOfNumberBookedSeatsInNextWeek()
    {
        return $this->getNumberBookedSeatsInNextWeek()/$this->seat_number;
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

        self::deleting(function ($restaurant) {
            $restaurant->reservations()->each(function ($item) {
                $item->delete();
            });
        });
    }

}
