<?php

namespace Tests\Feature\Http\Controller\Api\v1;

use App\Models\Reservation;
use App\Models\Restaurant;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ReservationControllerTest
 * docker exec -it app ./vendor/bin/phpunit --filter ReservationControllerTest
 *
 * debug:
 * $this->withoutExceptionHandling();
 */
class ReservationControllerTest extends TestCase
{
    use RefreshDatabase;

    /*
     * Run All TestCase
     * docker exec -it app ./vendor/bin/phpunit
     * */

    protected $endPoint = "/api/v1/reservations";

    protected $table = "reservations";


    /**
     * docker exec -it app ./vendor/bin/phpunit --filter non_authenticated_users_cannot_access_the_following_endpoint_for_reservations
     * @test
     */
    public function non_authenticated_users_cannot_access_the_following_endpoint_for_reservations()
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
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_collection_of_paginated_reservations
     * @test
     */
    public function can_return_a_collection_of_paginated_reservations()
    {
        $user = factory(User::class)->create();
        factory(Restaurant::class, 10)->create();
        factory(Reservation::class, 100)->create([
            'user_id'       => $user->id,
            'restaurant_id' => random_int(0, 100)
        ]);


        $response = $this->actingAs($user, 'api')
            ->json('GET', $this->endPoint);

        $response->assertStatus(200)
            ->assertJsonStructure([
                    '*' => [
                        'id',
                        'restaurant_id',
                        'user_id',
                        'number_people',
                        'booking_time',
                    ]
            ]);

    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_create_a_reservation
     * @test
     */
    public function can_create_a_reservation()
    {
        $user = factory(User::class)->create();
        $object = $this->generateObject($user);
        $response = $this->actingAs($user, 'api')
            ->json('POST', $this->endPoint, $object);
        $response
            ->assertJsonStructure([
                'id',
                'restaurant_id',
                'user_id',
                'number_people',
                'booking_time'])
            ->assertStatus(201);

        $this->assertDatabaseHas($this->table, [
            'restaurant_id' => $object['restaurant_id'],
            'user_id'       => $object['user_id'],
            'number_people' => $object['number_people'],
            'booking_time'  => $object['booking_time'],
        ]);
    }


    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_create_multi_reservation
     * @test
     */
    public function can_create_multi_reservation()
    {
        $user = factory(User::class)->create();
        for ($i = 1; $i < 11; $i++) {
            $this->create_reservation($user, $i);
        }
    }

    /**
     * @param User $user
     * @param int $i
     */
    public function create_reservation(User $user, int $i)
    {
        $object = $this->generateObject($user);

        $response = $this->actingAs($user, 'api')
            ->json('POST', $this->endPoint, $object);

        $response
            ->assertStatus(201)
            ->assertExactJson([
                'id'            => $i,
                'restaurant_id' => $object['restaurant_id'],
                'user_id'       => $object['user_id'],
                'number_people' => (string)$object['number_people'],
                'booking_time'  => $object['booking_time'],
            ]);

        $this->assertDatabaseHas($this->table, [
            'restaurant_id' => $object['restaurant_id'],
            'user_id'       => $object['user_id'],
            'number_people' => (string)$object['number_people'],
            'booking_time'  => $object['booking_time'],
        ]);
    }


    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_reservation
     * @test
     */
    public function can_return_a_reservation()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $object = factory(Reservation::class)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/" . $object->id);

        $response->assertStatus(200)
            ->assertExactJson([
                'id'            => $object->id,
                'restaurant_id' => (string)$object->restaurant_id,
                'user_id'       => (string)$object->user_id,
                'number_people' => (string)$object->number_people,
                'booking_time'  => $object->booking_time,
            ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_reservation_not_found
     * @test
     */
    public function will_fail_with_a_404_if_reservation_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/-1");

        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_401_if_we_want_to_update_reservation_not_found
     * @test
     */
    public function will_fail_with_a_401_if_we_want_to_update_reservation_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')
            ->json("PUT", $this->endPoint . "/-1");
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_update_a_reservation
     * @test
     */
    public function can_update_a_reservation()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = factory(Reservation::class)->create(['user_id' => $user->id]);
        $response = $this->actingAs($user, 'api')
            ->json("PUT", $this->endPoint . "/" . $object->id,
                [
                    'restaurant_id' => (string)$object->restaurant_id,
                    'user_id'       => (string)$object->user_id,
                    'number_people' => (string)($object->number_people + 10),
                    'booking_time'  => $object->booking_time,
                ]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'id'            => $object->id,
                'restaurant_id' => (string)$object->restaurant_id,
                'user_id'       => (string)$object->user_id,
                'number_people' => (string)($object->number_people + 10),
                'booking_time'  => $object->booking_time,
            ]);

        $this->assertDatabaseHas($this->table, [
            'id'            => $object->id,
            'restaurant_id' => (string)$object->restaurant_id,
            'user_id'       => (string)$object->user_id,
            'number_people' => (string)($object->number_people + 10),
            'booking_time'  => $object->booking_time,
        ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_we_want_to_delete_object_not_found
     * @test
     */
    public function will_fail_with_a_404_if_we_want_to_delete_object_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("DELETE", $this->endPoint . '/-1');
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_delete_a_reservation
     * @test
     */
    public function can_delete_a_reservation()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $restaurant = factory(Restaurant::class)->create();
        $reservation = factory(Reservation::class)->create([
            'restaurant_id' => $restaurant->id,
            'user_id'       => $user->id]);

        $response = $this->actingAs($user, 'api')
            ->json("DELETE", $this->endPoint . '/' . $reservation->id);

        $response
            ->assertStatus(204)
            ->assertSee(null);

        $this
            ->assertDatabaseMissing("reservations", [
                'id' => $reservation->id
            ]);
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
