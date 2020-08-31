<?php

namespace Tests\Feature\Http\Controller\Api\v1;

use App\Models\Category;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Http\Controller\Api\v1\Traits\generalFunction;
use Tests\TestCase;

/**
 * Class CategoryControllerTest
 * docker exec -it app ./vendor/bin/phpunit --filter CategoryControllerTest
 *
 * debug:
 * $this->withoutExceptionHandling();
 */
class CategoryControllerTest extends TestCase
{
    use RefreshDatabase, generalFunction;

    /*
     * Run All TestCase
     * docker exec -it app ./vendor/bin/phpunit
     * */

    protected $endPoint = "/api/v1/categories";
    protected $table = "categories";

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_collection_of_paginated_Categories
     * @test
     */
    public function can_return_a_collection_of_paginated_Categories()
    {
        //$this->withoutExceptionHandling();
        factory(Category::class, 50)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->json('GET', $this->endPoint);

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    "name",
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

        $object = $this->generateCategory($user);

        $response = $this->actingAs($user, 'api')
            ->json('POST', $this->endPoint, $object);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                "name",
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

        $object = factory(Category::class)->create($this->generateObject($user));

        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/" . $object->id);
        $response->assertStatus(200)
            ->assertExactJson([
                'id'   => $object->id,
                'name' => (string)$user->id,
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
        $object = factory(Category::class)->create($this->generateObject($user));

        $response = $this->actingAs($user, 'api')
            ->json("PUT", $this->endPoint . "/" . $object->id,
                [
                    'id'   => $object->id,
                    'name' => (string)$user->id,
                ]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'id'   => $object->id,
                'name' => (string)$user->id,
            ]);

        $this->assertDatabaseHas($this->table, [
            'id'   => $object->id,
            'name' => (string)$user->id,
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
        $object = $this->generateCategory($user);
        $object = factory(Category::class)->create($object);

        $response = $this->actingAs($user, 'api')->json("DELETE", $this->endPoint . '/' . $object->id);

        $response
            ->assertStatus(204)
            ->assertSee(null);
        $this
            ->assertDatabaseMissing($this->table, [
                'id' => $object->id
            ]);
    }

    private function generateCategory(User $user): array
    {
        $restaurant = factory(Restaurant::class)->create();
        $reservation = factory(Reservation::class)->create([
            'user_id'       => $user->id,
            'restaurant_id' => $restaurant->id,
        ]);

        return [
            "restaurant_id"  => $restaurant->id,
            "user_id"        => $user->id,
            "reservation_id" => $reservation->id,
            "message"        => "Category test"
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
}
