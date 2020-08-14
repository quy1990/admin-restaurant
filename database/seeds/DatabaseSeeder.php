<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RestaurantSeeder::class);
        $this->call(InvitationSeeder::class);
        $this->call(InvitedPeopleSeeder::class);
        $this->call(ReservationSeeder::class);
    }
}
