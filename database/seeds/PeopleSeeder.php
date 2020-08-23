<?php

use App\Models\Invitation;
use App\Models\People;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PeopleSeeder extends Seeder
{
    private $quantity = 5;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        People::truncate();
        Restaurant::truncate();
        Invitation::truncate();
        Reservation::truncate();

        $this->generateSuperAdmin();
        $this->generateRealData();
    }

    protected function generateSuperAdmin()
    {
        $user = factory(User::class)->create([
            "name"     => "abc",
            "email"    => "asdskj@dsd.com",
            "password" => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi"
        ]);

        $restaurant = factory(Restaurant::class)->create();


        $reservation = factory(Reservation::class)->create([
            'user_id'       => $user->id,
            'restaurant_id' => $restaurant->id
        ]);

        $invitation = factory(Invitation::class)->create([
            'user_id'        => $user->id,
            'reservation_id' => $reservation->id,
            'restaurant_id'  => $restaurant->id,
        ]);

        $people = factory(People::class)->create([
            'user_id'        => $user->id,
            'restaurant_id'  => $restaurant->id,
            'reservation_id' => $reservation->id,
            'invitation_id'  => $invitation->id,
        ]);
        $this->generateRoles();

        $user->roles()->attach(1);

        $user->ownedRestaurants()->attach(1);
    }

    protected function generateRoles()
    {
        $role1 = factory(Role::class)->create([
            'id' => '1',
            'name' => 'admin',
            'description' => 'something will be here'
        ]);


        $role2 = factory(Role::class)->create([
            'id' => '2',
            'name' => 'mod',
            'description' => 'something will be here'
        ]);

        $role3 = factory(Role::class)->create([
            'id' => '3',
            'name' => 'Restaurant Manager',
            'description' => 'something will be here'
        ]);
    }

    public function generateRealData()
    {
        for ($i = 0; $i < $this->quantity; $i++) {
            $user = factory(User::class)->create();

            $restaurant = factory(Restaurant::class)->create();

            for ($i = 0; $i < 3; $i++) {
                $reservation = factory(Reservation::class)->create([
                    'user_id'       => $user->id,
                    'restaurant_id' => $restaurant->id
                ]);

                for ($i = 0; $i < 3; $i++) {
                    $invitation = factory(Invitation::class)->create([
                        'user_id'        => $user->id,
                        'restaurant_id'  => $restaurant->id,
                        'reservation_id' => $reservation->id
                    ]);

                    for ($i = 0; $i < 3; $i++) {
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
