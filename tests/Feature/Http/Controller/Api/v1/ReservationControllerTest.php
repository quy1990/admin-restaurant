<?php

namespace Tests\Feature\Http\Controller\Api\v1;

use App\Models\Invitation;
use App\Models\People;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Http\Controller\Api\v1\Traits\generalFunction;
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
    use RefreshDatabase, generalFunction;

    /*
     * Run All TestCase
     * docker exec -it app ./vendor/bin/phpunit
     * */

    protected $endPoint = "/api/v1/reservations";
    protected $table = "reservations";
    protected $rowToCheck = 10;

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


    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_get_restaurant_of_the_invitation
     * @test
     */
    public function can_get_restaurant_of_the_reservation()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = $this->generateObject($user);
        $reservation = factory(Reservation::class)->create($object);
        $restaurant = $reservation->restaurant;
        $response = $this->actingAs($user, 'api')->json("GET",
            $this->endPoint . '/' . $reservation->id . '/restaurant');
        $response
            ->assertStatus(200)
            ->assertExactJson([
                'id'          => $restaurant->id,
                'name'        => $restaurant->name,
                'address'     => $restaurant->address,
                'email'       => $restaurant->email,
                'phone'       => $restaurant->phone,
                'seat_number' => $restaurant->seat_number,
            ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_get_reservation_of_the_invitation
     * @test
     */
    public function can_get_invitations_of_the_reservation()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = $this->generateObject($user);
        $reservation = factory(Reservation::class)->create($object);
        factory(Invitation::class, $this->rowToCheck)->create($this->generateInvitations($user, $reservation));
        $response = $this->actingAs($user, 'api')->json("GET",
            $this->endPoint . '/' . $reservation->id . '/invitations');
        $response->assertStatus(200)->assertJsonStructure([
            "*" => [
                "id",
                "user_id",
                "restaurant_id",
                "reservation_id",
                "message",
            ]
        ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_get_reservation_of_the_invitation
     * @test
     */
    public function can_get_peoples_of_the_invitation()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = $this->generateObject($user);
        $reservation = factory(Reservation::class)->create($object);
        $invitation = factory(Invitation::class)->create($this->generateInvitations($user, $reservation));
        factory(People::class)->create($this->generatePeople($user, $invitation));

        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . '/' . $invitation->id . '/peoples');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                "*" => [
                    "id",
                    "invitation_id",
                    "user_id",
                    "restaurant_id",
                    "email",
                    "phone",
                ]
            ]);
    }

    private function generateInvitations(User $user, Reservation $reservation): array
    {
        return [
            "user_id"        => $user->id,
            "restaurant_id"  => $reservation->restaurant->id,
            "reservation_id" => $reservation->id,
            "message"        => "Invitation test"
        ];
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_get_restaurant_of_the_invitation
     * @test
     */
    public function can_get_user_of_the_reservation()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = $this->generateObject($user);
        $reservation = factory(Reservation::class)->create($object);
        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . '/' . $reservation->id . '/user');
        $response
            ->assertStatus(200)
            ->assertExactJson([
                'id'   => (string)$user->id,
                'name' => $user->name,
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


    /**
     * @param User $user
     * @param Invitation $invitation
     * @return array
     */
    protected function generatePeople(User $user, Invitation $invitation): array
    {
        $faker = Factory::create();
        $peoples[] = [
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
        ];

        return [
            "user_id"        => $user->id,
            "invitation_id"  => $invitation->id,
            "reservation_id" => $invitation->reservation->id,
            "restaurant_id"  => $invitation->restaurant->id,
            'email'          => $faker->email,
            'phone'          => $faker->phoneNumber,
        ];
    }
}
