<?php

namespace Tests\Feature\Http\Controller\Api\v1;

use App\Models\Comment;
use App\Models\Restaurant;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Http\Controller\Api\v1\Traits\generalFunction;
use Tests\TestCase;

/**
 * Class CommentControllerTest
 * docker exec -it app ./vendor/bin/phpunit --filter CommentControllerTest
 *
 * debug:
 * $this->withoutExceptionHandling();
 */
class CommentControllerTest extends TestCase
{
    use RefreshDatabase, generalFunction;

    /*
     * Run All TestCase
     * docker exec -it app ./vendor/bin/phpunit
     * */

    protected $endPoint = "/api/v1/comments";
    protected $table = "comments";

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_collection_of_paginated_comments
     * @test
     */
    public function can_return_a_collection_of_paginated_comments()
    {
        //$this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        factory(Comment::class, 50)->create(['user_id' => $user->id]);
        $response = $this->actingAs($user, 'api')
            ->json('GET', $this->endPoint);

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    "body",
                    "user_id"
                ]
            ]);

    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_create_a_comment
     * @test
     */
    public function can_create_a_comment()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $object = $this->generateComment($user);
        $response = $this->actingAs($user, 'api')->json('POST', $this->endPoint, $object);
        $response->assertStatus(201)->assertJsonStructure([
            'id',
            "body",
            "user_id"
        ]);

        $this->assertDatabaseHas($this->table, [
            "body"    => $object['body'],
            "user_id" => $object['user_id'],
        ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_return_a_comment
     * @test
     */
    public function can_return_a_comment()
    {
        $user = factory(User::class)->create();
        $comment = $this->generateComment($user);
        $object = factory(Comment::class)->create($comment);

        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/" . $object->id);
        $response->assertStatus(200)
            ->assertExactJson([
                'id'      => $object->id,
                "body"    => $object['body'],
                "user_id" => (string)$object['user_id'],
            ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_comment_not_found
     * @test
     */
    public function will_fail_with_a_404_if_comment_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("GET", $this->endPoint . "/1");
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_we_want_to_update_comment_not_found
     * @test
     */
    public function will_fail_with_a_404_if_we_want_to_update_comment_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("PUT", $this->endPoint . "/1");
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_update_a_comment
     * @test
     */
    public function can_update_a_comment()
    {
        $user = factory(User::class)->create();
        $comment = $this->generateComment($user);
        $object = factory(Comment::class)->create($comment);
        $response = $this->actingAs($user, 'api')
            ->json("PUT", $this->endPoint . "/" . $object->id, [
                'id'   => $object->id,
                'body' => "update_" . $object['body'],
                'user_id' => $object['user_id'],
            ]);

        $response
            ->assertStatus(200)
            ->assertExactJson([
                'id'   => $object->id,
                'body' => "update_" . $object['body'],
                'user_id' => $object['user_id'],
            ]);

        $this->assertDatabaseHas($this->table, [
            'id'   => $object->id,
            'body' => "update_" . $object['body'],
            'user_id' => $object['user_id'],
        ]);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter will_fail_with_a_404_if_we_want_to_delete_comment_not_found
     * @test
     */
    public function will_fail_with_a_404_if_we_want_to_delete_comment_not_found()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json("DELETE", $this->endPoint . '/-1');
        $response->assertStatus(404);
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter can_delete_a_comment
     * @test
     */
    public function can_delete_a_comment()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $object = $this->generateComment($user);
        $object = factory(Comment::class)->create($object);

        $response = $this->actingAs($user, 'api')->json("DELETE", $this->endPoint . '/' . $object->id);

        $response
            ->assertStatus(204)
            ->assertSee(null);
        $this
            ->assertDatabaseMissing($this->table, [
                'id' => $object->id
            ]);
    }

    private function generateComment(User $user): array
    {
        return [
            "body"             => Factory::create()->text,
            "user_id"          => $user->id,
            "commentable_id"   => factory(Restaurant::class)->create()->id,
            "commentable_type" => "App\Models\Restaurant"
        ];
    }
}
