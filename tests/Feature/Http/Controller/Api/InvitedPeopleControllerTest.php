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
 * Class InvitedPeopleControllerTest
 * docker exec -it app ./vendor/bin/phpunit --filter InvitedPeopleControllerTest
 *
 * debug:
 * $this->withoutExceptionHandling();
 */
class InvitedPeopleControllerTest extends TestCase
{
    use RefreshDatabase;

    /*
     * Run All TestCase
     * docker exec -it app ./vendor/bin/phpunit
     * */

    protected $endPoint = "/api/invited_peoples";

    protected $table = "invited_peoples";

    protected $rowToCheck = 10;

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter non_authenticated_users_cannot_access_the_following_endpoint_for_invited_peoples
     * @test
     */
    public function non_authenticated_users_cannot_access_the_following_endpoint_for_invited_peoples()
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
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_collection_of_paginated_invited_peoples
     * @test
     */
    public function can_return_a_collection_of_paginated_invited_peoples()
    {
        $user = factory(User::class)->create();
        factory(People::class, $this->rowToCheck)->create([
            'user_id' => $user->id
        ]);


        $response = $this->actingAs($user, 'api')
            ->json('GET', $this->endPoint);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'invitation_id',
                        'user_id',
                        'email',
                        'phone',
                    ]
                ],
                "first_page_url",
                "from",
                "last_page",
                "last_page_url",
                "next_page_url",
                "path",
                "per_page",
                "prev_page_url",
                "to",
                "total"
            ]);

    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_create_a_invited_people
     * @test
     */
    public function can_create_a_invited_people()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = $this->generateObject($user);

        $response = $this->actingAs($user, 'api')
            ->json('POST', $this->endPoint, $object);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'invitation_id',
                        'user_id',
                        'email',
                        'phone'
                    ]
                ]
            ]);

        $this->assertDatabaseHas($this->table, [
            'invitation_id' => (string)$object['invitation_id'],
            'user_id'       => (string)$object['user_id'],
            'phone'         => $object['invitedInformations'][0]['phone'],
            'email'         => $object['invitedInformations'][0]['email'],
        ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_create_multi_invited_peoples
     * @test
     */
    public function can_create_multi_invited_peoples()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $object = $this->generateObjects($user);

        $response = $this->actingAs($user, 'api')
            ->json('POST', $this->endPoint, $object);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'invitation_id',
                        'email',
                        'phone'
                    ]
                ]
            ]);

        for ($i = 0; $i < $this->rowToCheck; $i++) {
            $this->assertDatabaseHas($this->table, [
                'invitation_id' => (string)$object['invitation_id'],
                'phone'         => $object['invitedInformations'][$i]['phone'],
                'email'         => $object['invitedInformations'][$i]['email'],
            ]);
        }
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_invited_people
     * @test
     */
    public function can_return_a_invited_people()
    {
        $user = factory(User::class)->create();
        $object = factory(People::class)->create(['user_id' => $user->id]);
        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/" . $object->id);

        $response->assertStatus(200)
            ->assertExactJson([
                'id'            => $object->id,
                'invitation_id' => (string)$object->invitation_id,
                'user_id'       => (string)$object->user_id,
                'email'         => $object->email,
                'phone'         => (string)$object->phone,
            ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_invited_people_not_found
     * @test
     */
    public function will_fail_with_a_404_if_invited_people_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/-1");
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_we_want_to_update_invited_people_not_found
     * @test
     */
    public function will_fail_with_a_404_if_we_want_to_update_invited_people_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')
            ->json("PUT", $this->endPoint . "/-1");
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_update_a_invited_people
     * @test
     */
    public function can_update_a_invited_people()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $restaurant = factory(Restaurant::class)->create();
        $reservation = factory(Reservation::class)->create([
            'user_id'       => $user->id,
            'restaurant_id' => $restaurant->id
        ]);
        $invitation = factory(Invitation::class)->create([
            'reservation_id' => $reservation->id
        ]);

        $object = factory(People::class)->create([
            'invitation_id' => $invitation->id,
            'user_id'       => $user->id,
        ]);

        $response = $this->actingAs($user, 'api')
            ->json("PUT", $this->endPoint . "/" . $object->id,
                [
                    'invitation_id' => $object->invitation_id,
                    'user_id'       => $object->user_id,
                    'email'         => "update_" . $object->email,
                    'phone'         => $object->phone,
                ]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'id'            => $object->id,
                'invitation_id' => (string)$object->invitation_id,
                'user_id'       => (string)$object->user_id,
                'email'         => "update_" . $object->email,
                'phone'         => (string)$object->phone,
            ]);

        $this->assertDatabaseHas($this->table, [
            'id'            => $object->id,
            'invitation_id' => (string)$object->invitation_id,
            'user_id'       => (string)$object->user_id,
            'email'         => "update_" . $object->email,
            'phone'         => (string)$object->phone,
        ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_we_want_to_delete_invited_people_not_found
     * @test
     */
    public function will_fail_with_a_404_if_we_want_to_delete_invited_people_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')
            ->json("DELETE", $this->endPoint . '/-1');
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_delete_a_invited_people
     * @test
     */
    public function can_delete_a_invited_people()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $restaurant = factory(Restaurant::class)->create();
        $reservation = factory(Reservation::class)->create([
            'user_id'=>$user->id,
            'restaurant_id' => $restaurant->id]);

        $invitation = factory(Invitation::class)->create(['reservation_id' => $reservation->id]);

        $object = factory(People::class)->create(['invitation_id' => $invitation->id]);

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
     * @param User $user
     * @return array
     */
    protected function generateObject(User $user): array
    {
        $faker = Factory::create();
        $reservation = factory(Reservation::class)->create([
            'user_id' => $user->id
        ]);

        $invitation = factory(Invitation::class)->create([
            'reservation_id' => $reservation->id
        ]);

        $invitedInformation[] = [
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
        ];

        return [
            'user_id'             => $user->id,
            'invitation_id'       => $invitation->id,
            'invitedInformations' => $invitedInformation
        ];
    }

    /**
     * @param User $user
     * @return array
     */
    protected function generateObjects(User $user): array
    {
        $invitedInformation = [];
        $faker = Factory::create();
        $reservation = factory(Reservation::class)->create(['user_id' => $user->id]);
        $invitation = factory(Invitation::class)->create(['reservation_id' => $reservation->id]);

        for ($i = 0; $i < $this->rowToCheck; $i++) {
            $invitedInformation[] = [
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
            ];
        }
        return [
            'user_id'             => $user->id,
            'invitation_id'       => $invitation->id,
            'invitedInformations' => $invitedInformation
        ];
    }
}
