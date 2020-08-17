<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static truncate()
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function format()
    {
        return [
            'id'        => (string)$this->id,
            'name'        => (string)$this->name,
        ];
    }

    public function getFullName()
    {
        return $this->name;
    }

    public function getFullNameWithLink()
    {
        return "<a href='". route('customers.show', ['customer' => $this->id])."'>".$this->name."</a>";
    }

    public function isSuperAdmin()
    {
        return true;
    }

    public function hasVerifiedEmail()
    {
        return true;
    }

    public function user_type()
    {
        return $this->belongsTo(UserType::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'reservations' )
            ->withPivot('number_people','booking_time');
    }

    public function ownedRestaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'restaurant_owner');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class );
    }

    public function peoples()
    {
        return $this->hasMany(People::class );
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class );
    }
}
