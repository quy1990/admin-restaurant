<?php

namespace Tests\Feature\Http\Controller\Api\v1;

use App\Models\Invitation;
use App\Models\People;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Http\Controller\Api\v1\Traits\generalFunction;
use Tests\TestCase;

/**
 * Class InvitationControllerTest
 * docker exec -it app ./vendor/bin/phpunit --filter InvitationControllerTest
 *
 * debug:
 * $this->withoutExceptionHandling();
 */
class InvitationControllerTest extends TestCase
{
    use RefreshDatabase, generalFunction;

    /*
     * Run All TestCase
     * docker exec -it app ./vendor/bin/phpunit
     * */

    protected $endPoint = "/api/v1/invitations";
    protected $table = "invitations";

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_collection_of_paginated_invitations
     * @test
     */
    public function can_return_a_collection_of_paginated_invitations()
    {
        $this->withoutExceptionHandling();
        factory(Invitation::class, 50)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->json('GET', $this->endPoint);

        $response->assertStatus(200)
            ->assertJsonStructure([
                    '*' => [
                        'id',
                        "user_id",
                        "restaurant_id",
                        'reservation_id',
                        'message',
                    ]
                ]);

    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_create_a_invitation
     * @test
     */
    public function can_create_a_invitation()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();

        $object = $this->generateInvitation($user);

        $response = $this->actingAs($user, 'api')
            ->json('POST', $this->endPoint, $object);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                    'id',
                    "user_id",
                    "restaurant_id",
                    'reservation_id',
                    'message',
            ]);

        $this->assertDatabaseHas($this->table, [
            'reservation_id' => $object['reservation_id'],
            'message'        => $object['message'],
        ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_invitation
     * @test
     */
    public function can_return_a_invitation()
    {
        $user = factory(User::class)->create();

        $object = factory(Invitation::class)->create($this->generateObject($user));

        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/" . $object->id);
        $response->assertStatus(200)
            ->assertExactJson([
                'id'             => $object->id,
                'user_id'        => (string)$user->id,
                'restaurant_id'  => (string)$object->restaurant_id,
                'reservation_id' => (string)$object->reservation_id,
                'message'        => $object->message,
            ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_invitation_not_found
     * @test
     */
    public function will_fail_with_a_404_if_invitation_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/-1");
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_we_want_to_update_invitation_not_found
     * @test
     */
    public function will_fail_with_a_404_if_we_want_to_update_invitation_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("PUT", $this->endPoint . "/-1");
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_update_a_invitation
     * @test
     */
    public function can_update_a_invitation()
    {
        $user = factory(User::class)->create();
        $object = factory(Invitation::class)->create($this->generateObject($user));

        $response = $this->actingAs($user, 'api')
            ->json("PUT", $this->endPoint . "/" . $object->id,
                [
                    'id'             => $object->id,
                    'user_id'        => (string)$user->id,
                    'restaurant_id'  => (string)$object->restaurant_id,
                    'reservation_id' => (string)$object->reservation_id,
                    'message'        => $object->message . "_update",
                ]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'id'             => $object->id,
                'user_id'        => (string)$user->id,
                'restaurant_id'  => (string)$object->restaurant_id,
                'reservation_id' => (string)$object->reservation_id,
                'message'        => $object->message . "_update",
            ]);

        $this->assertDatabaseHas($this->table, [
            'id'             => $object->id,
            'user_id'        => (string)$user->id,
            'restaurant_id'  => (string)$object->restaurant_id,
            'reservation_id' => (string)$object->reservation_id,
            'message'        => $object->message . "_update",
        ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_we_want_to_delete_invitation_not_found
     * @test
     */
    public function will_fail_with_a_404_if_we_want_to_delete_invitation_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("DELETE", $this->endPoint . '/-1');
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_delete_a_invitation
     * @test
     */
    public function can_delete_a_invitation()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = $this->generateInvitation($user);
        $object = factory(Invitation::class)->create($object);

        $response = $this->actingAs($user, 'api')->json("DELETE", $this->endPoint . '/' . $object->id);

        $response
            ->assertStatus(204)
            ->assertSee(null);
        $this
            ->assertDatabaseMissing($this->table, [
                'id' => $object->id
            ]);
    }


    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_get_restaurant_of_the_invitation
     * @test
     */
    public function can_get_restaurant_of_the_invitation()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = $this->generateInvitation($user);
        $invitation = factory(Invitation::class)->create($object);
        $restaurant = $invitation->restaurant;
        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . '/' . $invitation->id . '/restaurant');
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
    public function can_get_reservation_of_the_invitation()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = $this->generateInvitation($user);
        $invitation = factory(Invitation::class)->create($object);
        $reservation = $invitation->reservation;
        $response = $this->actingAs($user, 'api')->json("GET",
            $this->endPoint . '/' . $invitation->id . '/reservation');
        $response
            ->assertStatus(200)
            ->assertExactJson([
                'id'            => $reservation->id,
                'user_id'       => $reservation->user_id,
                'restaurant_id' => $reservation->restaurant_id,
                'number_people' => $reservation->number_people,
                'booking_time'  => $reservation->booking_time,
            ]);
    }


    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_get_reservation_of_the_invitation
     * @test
     */
    public function can_get_user_of_the_invitation()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = $this->generateInvitation($user);
        $invitation = factory(Invitation::class)->create($object);
        $user = $invitation->user;
        $response = $this->actingAs($user, 'api')->json("GET",
            $this->endPoint . '/' . $invitation->id . '/user');
        $response
            ->assertStatus(200)
            ->assertExactJson([
                'id'   => (string)$user->id,
                'name' => $user->name,
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
        $object = $this->generateInvitation($user);
        $invitation = factory(Invitation::class)->create($object);
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

    private function generateInvitation(User $user): array
    {
        $restaurant = factory(Restaurant::class)->create();
        $reservation = factory(Reservation::class)->create([
            'user_id'       => $user->id,
            'restaurant_id' => $restaurant->id,
        ]);

        return [
            "restaurant_id" => $restaurant->id,
            "user_id" => $user->id,
            "reservation_id" => $reservation->id,
            "message" => "Invitation test"
        ];
    }


    protected function generateObject(User $user): array
    {
        $faker = Factory::create();
        $restaurant = factory(Restaurant::class)->create();
        $reservation = factory(Reservation::class)->create([
            'user_id'       => $user->id,
            'restaurant_id' => $restaurant->id,
        ]);

        return [
            'reservation_id' => $reservation->id,
            'user_id'        => $user->id,
            'restaurant_id'  => $restaurant->id,
            'message'        => $faker->paragraph,
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
