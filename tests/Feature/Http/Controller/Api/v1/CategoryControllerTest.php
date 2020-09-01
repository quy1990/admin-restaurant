<?php

namespace Tests\Feature\Http\Controller\Api\v1;

use App\Models\Category;
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
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_collection_of_paginated_categories
     * @test
     */
    public function can_return_a_collection_of_paginated_categories()
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
     * docker exec -it app ./vendor/bin/phpunit --filter can_create_a_category
     * @test
     */
    public function can_create_a_category()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = $this->generateCategory();
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
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_category
     * @test
     */
    public function can_return_a_category()
    {
        $user = factory(User::class)->create();
        $category = $this->generateCategory();
        $object = factory(Category::class)->create($category);

        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/" . $object->id);
        $response->assertStatus(200)
            ->assertExactJson([
                'id'   => $object->id,
                'name' => $category['name'],
            ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_category
     * @test
     */
    public function can_get_restaurants_a_category()
    {
        $user = factory(User::class)->create();
        $object = $this->generateCategory();
        $category = factory(Category::class)->create($object);
        $restaurant = factory(Restaurant::class)->create();
        $restaurant->categories()->sync($category->id);
        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/" . $category->id."/restaurants");
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

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_category_not_found
     * @test
     */
    public function will_fail_with_a_404_if_category_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/1");
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_we_want_to_update_category_not_found
     * @test
     */
    public function will_fail_with_a_404_if_we_want_to_update_category_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("PUT", $this->endPoint . "/1");
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_update_a_category
     * @test
     */
    public function can_update_a_category()
    {
        $user = factory(User::class)->create();
        $category = $this->generateCategory();
        $object = factory(Category::class)->create($category);
        $response = $this->actingAs($user, 'api')
            ->json("PUT", $this->endPoint . "/" . $object->id, [
                'id'   => $object->id,
                'name' => "update_" . $category['name'],
            ]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'id'   => $object->id,
                'name' => "update_" . $category['name'],
            ]);

        $this->assertDatabaseHas($this->table, [
            'id'   => $object->id,
            'name' => "update_" . $category['name'],
        ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_we_want_to_delete_category_not_found
     * @test
     */
    public function will_fail_with_a_404_if_we_want_to_delete_category_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("DELETE", $this->endPoint . '/-1');
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_delete_a_category
     * @test
     */
    public function can_delete_a_category()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = $this->generateCategory();
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

    private function generateCategory(): array
    {
        return ["name" => Factory::create()->name,];
    }
}
