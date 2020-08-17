<?php

use App\Models\Invitation;
use App\Models\People;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;

class PeopleSeeder extends Seeder
{
    private $quantity = 10;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        People::truncate();
        User::truncate();
        Restaurant::truncate();
        Reservation::truncate();
        Invitation::truncate();

        $this->generateRealData();
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
                'user_id'        => random_int(1, $this->quantity),
                'reservation_id' => random_int(1, $this->quantity),
                'restaurant_id'  => random_int(1, $this->quantity),
            ]);
        }

        for ($i = 0; $i < $this->quantity; $i++) {
            factory(People::class)->create([
                'reservation_id' => random_int(1, $this->quantity),
                'invitation_id'  => random_int(1, $this->quantity),
                'restaurant_id'  => random_int(1, $this->quantity),
                'user_id'        => random_int(1, $this->quantity),
            ]);
        }

    }

    public function generateRealData()
    {
        for ($i = 0; $i < $this->quantity; $i++) {
            $user = factory(User::class)->create();

            $restaurant = factory(Restaurant::class)->create();

            for ($i = 0; $i < 5; $i++) {
                $reservation = factory(Reservation::class)->create([
                    'user_id'       => $user->id,
                    'restaurant_id' => $restaurant->id
                ]);

                for ($i = 0; $i < 5; $i++) {
                    $invitation = factory(Invitation::class)->create([
                        'user_id'        => $user->id,
                        'restaurant_id'  => $restaurant->id,
                        'reservation_id' => $reservation->id
                    ]);

                    for ($i = 0; $i < 5; $i++) {
                        factory(People::class)->create([
                            'user_id'        => $user->id,
                            'restaurant_id'  => $restaurant->id,
                            'reservation_id' => $reservation->id,
                            'invitation_id'  => $invitation->id,
                        ]);
                    }
                }
            }
        }

    }
}
