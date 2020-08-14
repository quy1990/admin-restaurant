<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define(Product::class, function (Faker $faker) {
    return [
        'name'           => $name = $faker->company,
        'price'          => $price = random_int(10, 100),
        'product_nummer' => $product_nummer = $faker->company . random_int(10, 100),
        'hersteller_id'  => $hersteller_id = random_int(1, 3),
    ];
});
