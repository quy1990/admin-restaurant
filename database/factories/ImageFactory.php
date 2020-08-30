<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Image;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        "url" => $faker->url,
        "imageable_id" => 1,
        "imageable_type" => "App\\Models\\Restaurant",
    ];
});
