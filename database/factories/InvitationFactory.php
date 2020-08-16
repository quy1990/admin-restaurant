<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Invitation;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Restaurant;
use Faker\Generator as Faker;


$factory->define(Invitation::class, function (Faker $faker) {
    return [
        'reservation_id' => factory(Reservation::class)->create(),
        'restaurant_id' => factory(Restaurant::class)->create(),
        'user_id'        => factory(User::class)->create(),
        'message'        => $faker->paragraph,
    ];
});
