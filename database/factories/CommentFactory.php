<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use App\User;
use App\Models\Restaurant;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        "body"             => $faker->name,
        'user_id'          => factory(User::class)->create(),
        "commentable_id"   => factory(Restaurant::class)->create(),
        "commentable_type" => "App\\Models\\Restaurant",
    ];
});
