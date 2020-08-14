<?php

use App\Models\Restaurant;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quantity = 100;
        Restaurant::truncate();
        factory(Restaurant::class, $quantity)->create();
    }
}
