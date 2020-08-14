<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
   protected $fillable = ["email"];
   
   public function Restaurants(){
      return $this
      ->belongsToMany("App\Models\Restaurant", "reservations")
      ->withPivot(["id", "number_people", "booking_time"]);
  }

   public function getFullName(){
      return $this->first_name." ".$this->last_name;
   }
}
