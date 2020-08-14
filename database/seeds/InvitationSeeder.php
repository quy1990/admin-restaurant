<?php

use Illuminate\Database\Seeder;
use App\Models\Invitation;
class InvitationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quantity = 100;
        Invitation::truncate();
        factory(Invitation::class, $quantity)->create();
    }
}
