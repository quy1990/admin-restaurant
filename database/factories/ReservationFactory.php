<?php
/** @var Factory $factory */

use Illuminate\Database\Eloquent\Factory;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\User;
use App\Models\User as Customer;
use Carbon\Carbon;

$factory->define(Reservation::class, function () {

    return [
        'restaurant_id' => factory(Restaurant::class)->create(),
        'user_id'       => factory(User::class)->create(),
        'booking_time'  => Carbon::now()->format('Y-m-d H:i:s'),
        'number_people' => random_int(30, 40),
    ];
});
