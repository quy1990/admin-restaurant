<?php

namespace Tests\Feature\Http\Controller\Api\v1;

use App\Models\Reservation;
use App\Models\Restaurant;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class UserControllerTest
 * docker exec -it app ./vendor/bin/phpunit --filter UserControllerTest
 *
 * debug:
 * $this->withoutExceptionHandling();
 */
class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /*
     * Run All TestCase
     * docker exec -it app ./vendor/bin/phpunit
     * */

    protected $endPoint = "/api/v1/users";
    protected $table = "invitations";
    protected $rowToCheck = 100;

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter user_cans_get_his_restaurants
     * @test
     */
    public function user_cans_get_his_restaurants()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $restaurants = factory(Restaurant::class, $this->rowToCheck)->create();
        $user->ownedRestaurants()->sync($restaurants->pluck('id'));

        $response = $this->actingAs($user, 'api')
            ->getJson($this->endPoint . '/' . $user->id . '/restaurants');

        $response
            ->assertStatus(200);

        $response
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'address',
                    'email',
                    'phone',
                    'seat_number'
                ]
            ]);
        for ($i = 0; $i < $this->rowToCheck; $i++) {
            $this->assertDatabaseHas("restaurants", [
                'id'          => $restaurants[$i]['id'],
                'name'        => $restaurants[$i]['name'],
                'address'     => $restaurants[$i]['address'],
                'email'       => $restaurants[$i]['email'],
                'phone'       => $restaurants[$i]['phone'],
                'seat_number' => $restaurants[$i]['seat_number'],
            ]);
        }
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter user_cans_get_his_reservations
     * @test
     */
    public function user_cans_get_his_reservations()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $reservations = factory(Reservation::class, $this->rowToCheck)->create($this->generateObject($user));

        $response = $this->actingAs($user, 'api')
            ->json("GET", $this->endPoint . '/' . $user->id . '/reservations');

        $response
            ->assertStatus(200);

        $response
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'restaurant_id',
                    'user_id',
                    'number_people',
                    'booking_time',
                ]
            ]);
        for ($i = 0; $i < $this->rowToCheck; $i++) {
            $this->assertDatabaseHas("reservations", [
                'id'            => $reservations[$i]['id'],
                'restaurant_id' => $reservations[$i]['restaurant_id'],
                'user_id'       => $reservations[$i]['user_id'],
                'number_people' => $reservations[$i]['number_people'],
                'booking_time'  => $reservations[$i]['booking_time'],
            ]);
        }
    }

    protected function generateObject(User $user)
    {
        $restaurant = factory(Restaurant::class)->create();
        return [
            'restaurant_id' => $restaurant->id,
            'user_id'       => $user->id,
            'booking_time'  => Carbon::now()->format('Y-m-d H:i:s'),
            'number_people' => random_int(30, 40),
        ];
    }
}
