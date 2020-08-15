<?php

namespace Tests\Feature\Http\Controller\Api;

use App\Models\Invitation;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Faker\Factory;

/**
 * Class InvitationControllerTest
 * docker exec -it app ./vendor/bin/phpunit --filter InvitationControllerTest
 *
 * debug:
 * $this->withoutExceptionHandling();
 */
class InvitationControllerTest extends TestCase
{
    use RefreshDatabase;

    /*
     * Run All TestCase
     * docker exec -it app ./vendor/bin/phpunit
     * */

    protected $endPoint = "/api/invitations";
    protected $table = "invitations";

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter non_authenticated_users_cannot_access_the_following_endpoint_for_invitations
     * @test
     */
    public function non_authenticated_users_cannot_access_the_following_endpoint_for_invitations()
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
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_collection_of_paginated_invitations
     * @test
     */
    public function can_return_a_collection_of_paginated_invitations()
    {
        factory(Invitation::class, 50)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->json('GET', $this->endPoint);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'reservation_id',
                        'message',
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
     * docker exec -it app ./vendor/bin/phpunit --filter can_create_a_invitation
     * @test
     */
    public function can_create_a_invitation()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $object = $this->generateObject($user);

        $response = $this->actingAs($user, 'api')
            ->json('POST', $this->endPoint, $object);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
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
        $object = factory(Invitation::class)->create();
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/" . $object->id);
        $response->assertStatus(200)
            ->assertExactJson([
                'id'             => $object->id,
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
        $object = factory(Invitation::class)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->json("PUT", $this->endPoint . "/" . $object->id,
                [
                    'reservation_id' => $object->reservation_id,
                    'message'        => $object->message . "_update",
                ]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'id'             => $object->id,
                'reservation_id' => (string)$object->reservation_id,
                'message'        => $object->message . "_update",
            ]);

        $this->assertDatabaseHas($this->table, [
            'id'             => $object->id,
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
        $object = factory(Invitation::class)->create();
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

    protected function generateObject(User $user): array
    {
        $faker = Factory::create();
        $reservation = factory(Reservation::class)->create(['user_id' => $user->id]);
        return [
            'reservation_id' => $reservation->id,
            'message'        => $faker->paragraph,
        ];
    }
}
