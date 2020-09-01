<?php

namespace Tests\Feature\Http\Controller\Api\v1;

use App\Models\Image;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Http\Controller\Api\v1\Traits\generalFunction;
use Tests\TestCase;

/**
 * Class ImageControllerTest
 * docker exec -it app ./vendor/bin/phpunit --filter ImageControllerTest
 *
 * debug:
 * $this->withoutExceptionHandling();
 */
class ImageControllerTest extends TestCase
{
    use RefreshDatabase, generalFunction;

    /*
     * Run All TestCase
     * docker exec -it app ./vendor/bin/phpunit
     * */

    protected $endPoint = "/api/v1/images";
    protected $table = "images";

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_collection_of_paginated_images
     * @test
     */
    public function can_return_a_collection_of_paginated_images()
    {
        //$this->withoutExceptionHandling();
        factory(Image::class, 50)->create();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->json('GET', $this->endPoint);

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    "url",
                ]
            ]);

    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_create_a_image
     * @test
     */
    public function can_create_a_image()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = $this->generateImage();
        $response = $this->actingAs($user, 'api')
            ->json('POST', $this->endPoint, $object);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                "url",
            ]);

        $this->assertDatabaseHas($this->table, [
            'url' => $object['url'],
        ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_image
     * @test
     */
    public function can_return_a_image()
    {
        $user = factory(User::class)->create();
        $image = $this->generateImage();
        $object = factory(Image::class)->create($image);

        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/" . $object->id);
        $response->assertStatus(200)
            ->assertExactJson([
                'id'  => $object->id,
                'url' => $image['url'],
            ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_image_not_found
     * @test
     */
    public function will_fail_with_a_404_if_image_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/1");
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_we_want_to_update_image_not_found
     * @test
     */
    public function will_fail_with_a_404_if_we_want_to_update_image_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("PUT", $this->endPoint . "/1");
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_update_a_image
     * @test
     */
    public function can_update_a_image()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $image = $this->generateImage();
        $object = factory(Image::class)->create($image);
        $response = $this->actingAs($user, 'api')
            ->json("PUT", $this->endPoint . "/" . $object->id, [
                'id'             => $object->id,
                'url'            => "update_" . $image['url'],
                'imageable_id'   => $object['imageable_id'],
                'imageable_type' => $object['imageable_type'],
            ]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'id'             => $object->id,
                'url'            => "update_" . $image['url'],
            ]);

        $this->assertDatabaseHas($this->table, [
            'id'             => $object->id,
            'url'            => "update_" . $image['url'],
            'imageable_id'   => $object['imageable_id'],
            'imageable_type' => $object['imageable_type'],
        ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_we_want_to_delete_image_not_found
     * @test
     */
    public function will_fail_with_a_404_if_we_want_to_delete_image_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("DELETE", $this->endPoint . '/-1');
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_delete_a_image
     * @test
     */
    public function can_delete_a_image()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = $this->generateImage();
        $object = factory(Image::class)->create($object);
        $response = $this->actingAs($user, 'api')->json("DELETE", $this->endPoint . '/' . $object->id);
        $response
            ->assertStatus(204)
            ->assertSee(null);
        $this
            ->assertDatabaseMissing($this->table, [
                'id' => $object->id
            ]);
    }

    private function generateImage(): array
    {
        return [
            "url"            => Factory::create()->url,
            'imageable_id'   => 1,
            'imageable_type' => "App\Models\Restaurant",
        ];
    }
}
