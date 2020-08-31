<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Image;
use App\Models\Restaurant;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        "url" => $faker->url,
        "commentable_id"   => factory(Restaurant::class)->create(),
        "imageable_type" => "App\\Models\\Restaurant",
    ];
});
