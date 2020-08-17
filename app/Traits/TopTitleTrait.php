<?php
namespace App\Traits;

use App\Models\Invitation;
use App\Models\People;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;

trait TopTitleTrait{

    public function getCountRestaurant(){
        return Restaurant::all()->count();
    }
    public function getCountReservation(){
        return Reservation::all()->count();
    }
    public function getCountInvitation(){
        return Invitation::all()->count();
    }
    public function getCountInvitedPeople(){
        return People::all()->count();
    }
    public function getCountUser(){
        return User::all()->count();
    }
}
