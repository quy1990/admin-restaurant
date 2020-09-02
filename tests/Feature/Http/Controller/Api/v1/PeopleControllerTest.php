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
 * Class PeopleControllerTest
 * docker exec -it app ./vendor/bin/phpunit --filter PeopleControllerTest
 *
 * debug:
 * $this->withoutExceptionHandling();
 */
class PeopleControllerTest extends TestCase
{
    use RefreshDatabase, generalFunction;


    /*
     * Run All TestCase
     * docker exec -it app ./vendor/bin/phpunit
     * */

    protected $endPoint = "/api/v1/peoples";
    protected $table = "peoples";
    protected $rowToCheck = 10;


    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_collection_of_paginated_peoples
     * @test
     */
    public function can_return_a_collection_of_paginated_peoples()
    {
        $user = factory(User::class)->create();
        factory(People::class, $this->rowToCheck)->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user, 'api')
            ->json('GET', $this->endPoint);

        $response->assertStatus(200)
            ->assertJsonStructure([
                    '*' => [
                        'id',
                        'invitation_id',
                        'user_id',
                        'email',
                        'phone',
                    ]
            ]);

    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_create_a_people
     * @test
     */
    public function can_create_a_people()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = $this->generateObject($user);

        $response = $this->actingAs($user, 'api')
            ->json('POST', $this->endPoint, $object);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                "*" => [
                    'id',
                    'invitation_id',
                    'user_id',
                    'restaurant_id',
                    'email',
                    'phone'
                ]
            ]);

        $this->assertDatabaseHas($this->table, [
            'invitation_id' => (string)$object['invitation_id'],
            'user_id'       => (string)$object['user_id'],
            'phone'         => $object['peoples'][0]['phone'],
            'email'         => $object['peoples'][0]['email'],
        ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_create_multi_peoples
     * @test
     */
    public function can_create_multi_peoples()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = $this->generateObjects($user);
        $response = $this->actingAs($user, 'api')->json('POST', $this->endPoint, $object);
        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'invitation_id',
                    'email',
                    'phone'
                ]
            ]);

        for ($i = 0; $i < $this->rowToCheck; $i++) {
            $this->assertDatabaseHas($this->table, [
                'invitation_id' => (string)$object['invitation_id'],
                'phone'         => $object['peoples'][$i]['phone'],
                'email'         => $object['peoples'][$i]['email'],
            ]);
        }
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_create_multi_peoples
     * @test
     */
    public function will_fail_with_multi_non_peoples()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = $this->generateObjectsWithoutPeoples($user);
        $response = $this->actingAs($user, 'api')->json('POST', $this->endPoint, $object);
        $response
            ->assertStatus(500);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_people
     * @test
     */
    public function can_return_a_people()
    {
        $user = factory(User::class)->create();
        $object = factory(People::class)->create(['user_id' => $user->id]);
        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/" . $object->id);

        $response->assertStatus(200)
            ->assertExactJson([
                'id'            => $object->id,
                'invitation_id' => (string)$object->invitation_id,
                'user_id'       => (string)$object->user_id,
                'restaurant_id' => (string)$object->restaurant_id,
                'email'         => $object->email,
                'phone'         => (string)$object->phone,
            ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_people_not_found
     * @test
     */
    public function will_fail_with_a_404_if_people_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/1");
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_403_if_we_want_to_update_people_not_found
     * @test
     */
    public function will_fail_with_a_403_if_we_want_to_update_people_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')
            ->json("PUT", $this->endPoint . "/1");
        $response->assertStatus(403);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_we_want_to_delete_people_not_found
     * @test
     */
    public function will_fail_with_a_404_if_we_want_to_delete_people_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')
            ->json("DELETE", $this->endPoint . '/-1');
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_delete_a_people
     * @test
     */
    public function can_delete_a_people()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = $this->generatePeople($user);
        $people = factory(People::class)->create($object);
        $response = $this->actingAs($user, 'api')
            ->deleteJson($this->endPoint . '/' . $people->id);

        $response->assertStatus(204)->assertSee(null);

        $this->assertDatabaseMissing($this->table, [
            'id' => (string)$people->id
        ]);
    }

    /**
     * @param User $user
     * @return array
     */
    protected function generatePeople(User $user): array
    {
        $faker = Factory::create();
        $restaurant = factory(Restaurant::class)->create();
        $reservation = factory(Reservation::class)->create([
            'user_id'       => $user->id,
            'restaurant_id' => $restaurant->id,
        ]);

        $invitation = factory(Invitation::class)->create([
            'user_id'        => $user->id,
            'restaurant_id'  => $restaurant->id,
            'reservation_id' => $reservation->id,
        ]);

        $peoples[] = [
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
        ];

        return [
            "user_id"        => $user->id,
            "invitation_id"  => $invitation->id,
            "reservation_id" => $reservation->id,
            "restaurant_id"  => $restaurant->id,
            'email'          => $faker->email,
            'phone'          => $faker->phoneNumber,
        ];
    }

    /**
     * @param User $user
     * @return array
     */
    protected function generateObject(User $user): array
    {
        $faker = Factory::create();
        $restaurant = factory(Restaurant::class)->create();
        $reservation = factory(Reservation::class)->create([
            'user_id'       => $user->id,
            'restaurant_id' => $restaurant->id,
        ]);

        $invitation = factory(Invitation::class)->create([
            'user_id'        => $user->id,
            'restaurant_id'  => $restaurant->id,
            'reservation_id' => $reservation->id,
        ]);

        $peoples[] = [
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
        ];

        return [
            "user_id"        => $user->id,
            "invitation_id"  => $invitation->id,
            "reservation_id" => $reservation->id,
            "restaurant_id"  => $restaurant->id,
            'peoples'        => $peoples,
        ];
    }

    protected function generateObjects(User $user): array
    {
        $faker = Factory::create();
        $restaurant = factory(Restaurant::class)->create();
        $reservation = factory(Reservation::class)->create([
            'user_id'       => $user->id,
            'restaurant_id' => $restaurant->id,
        ]);

        $invitation = factory(Invitation::class)->create([
            'user_id'        => $user->id,
            'restaurant_id'  => $restaurant->id,
            'reservation_id' => $reservation->id,
        ]);
        $peoples = array();
        for ($i = 0; $i < $this->rowToCheck; $i++) {
            $peoples[] = [
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
            ];
        }

        return [
            "invitation_id"  => $invitation->id,
            "reservation_id" => $reservation->id,
            "restaurant_id"  => $restaurant->id,
            "user_id"        => $user->id,
            'peoples'        => $peoples
        ];
    }


    protected function generateObjectsWithoutPeoples(User $user): array
    {
        $restaurant = factory(Restaurant::class)->create();
        $reservation = factory(Reservation::class)->create([
            'user_id'       => $user->id,
            'restaurant_id' => $restaurant->id,
        ]);

        $invitation = factory(Invitation::class)->create([
            'user_id'        => $user->id,
            'restaurant_id'  => $restaurant->id,
            'reservation_id' => $reservation->id,
        ]);

        return [
            "invitation_id"  => $invitation->id,
            "reservation_id" => $reservation->id,
            "restaurant_id"  => $restaurant->id,
            "user_id"        => $user->id
        ];
    }
}
