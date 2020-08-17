<?php

namespace Tests\Feature\Http\Controller\Api;

use App\Models\Invitation;
use App\Models\People;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class RestaurantControllerTest
 * docker exec -it app ./vendor/bin/phpunit --filter RestaurantControllerTest
 *
 * debug:
 * $this->withoutExceptionHandling();
 */
class RestaurantControllerTest extends TestCase
{
    use RefreshDatabase;

    /*
     * Run All TestCase
     * docker exec -it app ./vendor/bin/phpunit
     * */

    protected $endPoint = "/api/restaurants";
    protected $table = "restaurants";
    protected $rowToCheck = 10;

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter non_authenticated_users_cannot_access_the_following_endpoint_for_restaurants
     * @test
     */
    public function non_authenticated_users_cannot_access_the_following_endpoint_for_restaurants()
    {
        $index = $this->json("GET", $this->endPoint);
        $index->assertStatus(401);

        $store = $this->json("POST", $this->endPoint);
        $store->assertStatus(401);

        $show = $this->json("GET", $this->endPoint . "/-1");
        $show->assertStatus(401);

        $update = $this->json("PUT", $this->endPoint . "/-1");
        $update->assertStatus(401);

        $destroy = $this->json("DELETE", $this->endPoint . "/-1");
        $destroy->assertStatus(401);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_collection_of_paginated_restaurants
     * @test
     */
    public function can_return_a_collection_of_paginated_restaurants()
    {
        factory(Restaurant::class, 10)->create();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->json('GET', $this->endPoint);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'address',
                        'email',
                        'phone',
                        'seat_number',
                    ]
                ],
                "first_page_url", "from", "last_page", "last_page_url", "next_page_url",
                "path", "per_page", "prev_page_url", "to", "total"
            ]);

    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_create_a_restaurant
     * @test
     */
    public function can_create_a_restaurant()
    {
        $this->withoutExceptionHandling();

        $object = $this->generateObject();

        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->json('POST', $this->endPoint, $object);

        $response
            ->assertStatus(201)
            ->assertExactJson([
                'id'          => 1,
                'name'        => $object['name'],
                'address'     => $object['address'],
                'email'       => $object['email'],
                'phone'       => $object['phone'],
                'seat_number' => (string)$object['seat_number'],
            ]);

        $this->assertDatabaseHas($this->table, [
            'name'        => $object['name'],
            'address'     => $object['address'],
            'email'       => $object['email'],
            'phone'       => $object['phone'],
            'seat_number' => $object['seat_number'],
        ]);

        $this->assertDatabaseHas('restaurant_owner', [
            'user_id'       => $user->id,
            'restaurant_id' => 1
        ]);
    }


    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_create_more_restaurant
     * @test
     */
    public function can_create_more_restaurant()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        for ($i = 1; $i < $this->rowToCheck; $i++) {
            $this->create_restaurants($user, $i);
        }

    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_restaurant
     * @test
     */
    public function can_return_a_restaurant()
    {
        $user = factory(User::class)->create();
        $object = factory(Restaurant::class)->create();

        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/" . $object->id);

        $response->assertStatus(200)
            ->assertExactJson([
                'id'          => $object->id,
                'name'        => $object->name,
                'address'     => $object->address,
                'email'       => $object->email,
                'phone'       => $object->phone,
                'seat_number' => (string)$object->seat_number,
            ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_object_not_found
     * @test
     */
    public function will_fail_with_a_404_if_object_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/-1");
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_we_want_to_update_object_not_found
     * @test
     */
    public function will_fail_with_a_404_if_we_want_to_update_object_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')
            ->json("PUT", $this->endPoint . "/-1");
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_update_a_restaurant
     * @test
     */
    public function can_update_a_restaurant()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $object = factory(Restaurant::class)->create();
        $user->ownedRestaurants()->attach($object->id);

        $response = $this->actingAs($user, 'api')
            ->json("PUT", $this->endPoint . "/" . $object->id,
                [
                    'name'        => $object->name . "_update",
                    'address'     => $object->address . "_update",
                    'email'       => $object->email . "_update",
                    'phone'       => $object->phone . "_update",
                    'seat_number' => $object->seat_number + 10,
                ]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'id'          => $object->id,
                'name'        => $object->name . "_update",
                'address'     => $object->address . "_update",
                'email'       => $object->email . "_update",
                'phone'       => $object->phone . "_update",
                'seat_number' => (string)($object->seat_number + 10),
            ]);

        $this->assertDatabaseHas($this->table, [
            'id'          => $object->id,
            'name'        => $object->name . "_update",
            'address'     => $object->address . "_update",
            'email'       => $object->email . "_update",
            'phone'       => $object->phone . "_update",
            'seat_number' => $object->seat_number + 10,
        ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_we_want_to_delete_restaurant_not_found
     * @test
     */
    public function will_fail_with_a_404_if_we_want_to_delete_restaurant_not_found()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')->json("DELETE", $this->endPoint . '/-1');

        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_delete_a_restaurant
     * @test
     */
    public function can_delete_a_restaurant()
    {
        $object = factory(Restaurant::class)->create();
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')
            ->json("DELETE", $this->endPoint . '/' . $object->id);

        $response
            ->assertStatus(204)
            ->assertSee(null);
        $this
            ->assertDatabaseMissing($this->table, [
                'id' => $object->id
            ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_get_all_reservations_of_a_restaurant
     * @test
     */
    public function can_get_all_reservations_of_a_restaurant()
    {
        $this->withoutExceptionHandling();

        $data = $this->create_relation();

        $restaurant = $data['restaurant'];
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->json("GET", $this->endPoint . '/' . $restaurant['id'] . '/reservations');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'restaurant_id',
                        'user_id',
                        'number_people',
                        'booking_time',
                    ]
                ],
                "first_page_url", "from", "last_page", "last_page_url", "next_page_url",
                "path", "per_page", "prev_page_url", "to", "total"
            ]);
    }

    private function generateObject(): array
    {
        $faker = Factory::create();

        return [
            'name'        => $faker->name,
            'address'     => $faker->address,
            'email'       => $faker->email,
            'phone'       => $faker->phoneNumber,
            'seat_number' => random_int(30, 40),
        ];
    }

    private function create_relation()
    {
        $user = factory(User::class)->create();
        $restaurant = factory(Restaurant::class)->create();

        // user reserves with a restaurant
        $reservation = factory(Reservation::class)->create([
            'restaurant_id' => $restaurant->id,
            'user_id'       => $user->id
        ]);

        $invitation = factory(Invitation::class)->create([
            'reservation_id' => $reservation->id
        ]);

        $invitedPeople = factory(People::class)->create([
            'invitation_id' => $invitation->id
        ]);

        $this->create_more_relation();

        return [
            'user'          => $user,
            'restaurant'    => $restaurant,
            'reservation'   => $reservation,
            'invitation'    => $invitation,
            'invitedPeople' => $invitedPeople,
        ];
    }

    private function create_more_relation()
    {
        factory(User::class, 5)->create();
        factory(Restaurant::class, 100)->create();

        factory(Reservation::class, 100)->create([
            'restaurant_id' => random_int(0, 99),
            'user_id'       => random_int(0, 4)
        ]);

        factory(Invitation::class, 100)->create([
            'reservation_id' => random_int(0, 99)
        ]);

        factory(People::class)->create(['invitation_id' => random_int(0, 99)]);
    }

    /**
     * @param User $user
     * @param int $i
     */
    public function create_restaurants(User $user, int $i)
    {
        $object = $this->generateObject();

        $response = $this->actingAs($user, 'api')
            ->json('POST', $this->endPoint, $object);

        $response
            ->assertStatus(201)
            ->assertExactJson([
                'id'          => $i,
                'name'        => $object['name'],
                'address'     => $object['address'],
                'email'       => $object['email'],
                'phone'       => $object['phone'],
                'seat_number' => (string)$object['seat_number'],
            ]);

        $this->assertDatabaseHas($this->table, [
            'name'        => $object['name'],
            'address'     => $object['address'],
            'email'       => $object['email'],
            'phone'       => $object['phone'],
            'seat_number' => (string)$object['seat_number'],
        ]);

        $this->assertDatabaseHas('restaurant_owner', [
            'user_id'       => (string)$user->id,
            'restaurant_id' => (string)$i
        ]);
    }
}
