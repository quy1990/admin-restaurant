<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Invitation;
use App\Models\Reservation;
use Faker\Generator as Faker;


$factory->define(Invitation::class, function (Faker $faker) {
    return [
        'reservation_id' => factory(Reservation::class)->create(),
        'message'        => $faker->paragraph,
    ];
});
