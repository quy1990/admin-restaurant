<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Restaurant;
use Faker\Generator as Faker;

$factory->define(Restaurant::class, function (Faker $faker) {
    return [
        'name'        => $faker->name,
        'address'     => $faker->address,
        'email'       => $faker->email,
        'phone'       => $faker->phoneNumber,
        'seat_number' => random_int(30, 200),
    ];
});
