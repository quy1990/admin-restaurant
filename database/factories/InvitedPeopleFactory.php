<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Invitation;
use App\Models\InvitedPeople;
use App\Models\User;
use Faker\Generator as Faker;


$factory->define(InvitedPeople::class, function (Faker $faker) {
    return [
        'invitation_id' => factory(Invitation::class)->create(),
        'user_id'       => factory(User::class)->create(),
        'email'         => $faker->email,
        'phone'         => $faker->phoneNumber,

    ];
});
