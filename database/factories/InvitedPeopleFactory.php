<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Invitation;
use App\Models\People;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Reservation;
use Faker\Generator as Faker;


$factory->define(People::class, function (Faker $faker) {
    return [
        'user_id'       => factory(User::class)->create(),
        'invitation_id' => factory(Invitation::class)->create(),
        'restaurant_id' => factory(Restaurant::class)->create(),
        'reservation_id' => factory(Reservation::class)->create(),
        'email'         => $faker->email,
        'phone'         => $faker->phoneNumber,

    ];
});
