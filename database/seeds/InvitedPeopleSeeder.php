<?php

use Illuminate\Database\Seeder;
use App\Models\InvitedPeople;
class InvitedPeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quantity = 100;
        InvitedPeople::truncate();
        factory(InvitedPeople::class, $quantity)->create();
    }
}
