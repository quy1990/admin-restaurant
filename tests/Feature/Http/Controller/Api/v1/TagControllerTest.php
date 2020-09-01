<?php

namespace Tests\Feature\Http\Controller\Api\v1;

use App\Models\Restaurant;
use App\Models\Tag;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Http\Controller\Api\v1\Traits\generalFunction;
use Tests\TestCase;

/**
 * Class TagControllerTest
 * docker exec -it app ./vendor/bin/phpunit --filter TagControllerTest
 *
 * debug:
 * $this->withoutExceptionHandling();
 */
class TagControllerTest extends TestCase
{
    use RefreshDatabase, generalFunction;

    /*
     * Run All TestCase
     * docker exec -it app ./vendor/bin/phpunit
     * */

    protected $endPoint = "/api/v1/tags";
    protected $table = "tags";

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_collection_of_paginated_Categories
     * @test
     */
    public function can_return_a_collection_of_paginated_Categories()
    {
        //$this->withoutExceptionHandling();
        factory(Tag::class, 50)->create();
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
     * docker exec -it app ./vendor/bin/phpunit --filter can_create_a_tag
     * @test
     */
    public function can_create_a_tag()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = $this->generateTag();
        $response = $this->actingAs($user, 'api')
            ->json('POST', $this->endPoint, $object);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                "name",
            ]);

        $this->assertDatabaseHas($this->table, [
            'name' => $object['name'],
        ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_tag
     * @test
     */
    public function can_return_a_tag()
    {
        $user = factory(User::class)->create();
        $tag = $this->generateTag();
        $object = factory(Tag::class)->create($tag);

        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/" . $object->id);
        $response->assertStatus(200)
            ->assertExactJson([
                'id'   => $object->id,
                'name' => $tag['name'],
            ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_tag_not_found
     * @test
     */
    public function will_fail_with_a_404_if_tag_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/1");
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_we_want_to_update_tag_not_found
     * @test
     */
    public function will_fail_with_a_404_if_we_want_to_update_tag_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("PUT", $this->endPoint . "/1");
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_update_a_tag
     * @test
     */
    public function can_update_a_tag()
    {
        $user = factory(User::class)->create();
        $tag = $this->generateTag();
        $object = factory(Tag::class)->create($tag);
        $response = $this->actingAs($user, 'api')
            ->json("PUT", $this->endPoint . "/" . $object->id, [
                'id'   => $object->id,
                'name' => "update_" . $tag['name'],
            ]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'id'   => $object->id,
                'name' => "update_" . $tag['name'],
            ]);

        $this->assertDatabaseHas($this->table, [
            'id'   => $object->id,
            'name' => "update_" . $tag['name'],
        ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_we_want_to_delete_tag_not_found
     * @test
     */
    public function will_fail_with_a_404_if_we_want_to_delete_tag_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("DELETE", $this->endPoint . '/-1');
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_delete_a_tag
     * @test
     */
    public function can_delete_a_tag()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $object = $this->generateTag();
        $object = factory(Tag::class)->create($object);

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
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_category
     * @test
     */
    public function can_get_restaurants_a_category()
    {
        $user = factory(User::class)->create();
        $tag = factory(Tag::class)->create();
        $restaurant = factory(Restaurant::class)->create();
        $restaurant->tags()->sync($tag->id);
        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/" . $tag->id . "/restaurants");
        $response->assertStatus(200)
            ->assertJsonStructure([
                "*" => [
                    "id",
                    "name",
                    "address",
                    "email",
                    "phone",
                    "seat_number",
                ]
            ]);
    }

    private function generateTag(): array
    {
        return ["name" => Factory::create()->name,];
    }
}
