<?php
namespace App\Traits;

use App\Models\Invitation;
use App\Models\People;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\UserType;

trait UserTrait
{

    public function isSuperAdmin(): bool
    {
        return $this->role_id == 1;
    }

    public function hasRight(): bool
    {
        return $this->user_type_id > 5;
    }

    public function hasVerifiedEmail()
    {
        return true;
    }

    public function getFullName()
    {
        return $this->name;
    }

    public function getFullNameWithLink()
    {
        return "<a href='" . route('customers.show', ['customer' => $this->id]) . "'>" . $this->name . "</a>";
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
        return $this->belongsToMany(Restaurant::class, 'reservations')
            ->withPivot('number_people', 'booking_time');
    }

    public function ownedRestaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'restaurant_owner');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function peoples()
    {
        return $this->hasMany(People::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

}
