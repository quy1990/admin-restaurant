<?php

use App\Models\Invitation;
use App\Models\InvitedPeople;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;

class InvitedPeopleSeeder extends Seeder
{
    private $quantity = 100;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InvitedPeople::truncate();
        User::truncate();
        Restaurant::truncate();
        Reservation::truncate();
        Invitation::truncate();
        $this->generateObjects();
    }

    protected function generateObjects()
    {
        factory(User::class, $this->quantity)->create();

        factory(Restaurant::class, $this->quantity)->create();

        for ($i = 0; $i < $this->quantity; $i++) {
            factory(Reservation::class)->create([
                'user_id'       => random_int(1, $this->quantity),
                'restaurant_id' => random_int(1, $this->quantity)
            ]);
        }

        for ($i = 0; $i < $this->quantity; $i++) {
            factory(Invitation::class)->create([
                'reservation_id' => random_int(1, $this->quantity),
                'user_id'        => random_int(1, $this->quantity),
            ]);
        }

        for ($i = 0; $i < $this->quantity; $i++) {
            factory(InvitedPeople::class)->create([
                'invitation_id' => random_int(1, $this->quantity),
            ]);
        }

    }
}
