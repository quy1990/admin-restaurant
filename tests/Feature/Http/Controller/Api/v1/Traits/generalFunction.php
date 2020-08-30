<?php
namespace Tests\Feature\Http\Controller\Api\v1\Traits;

trait generalFunction {

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter non_authenticated_users_cannot_access_the_following_endpoint_for_restaurants
     */
    public function non_authenticated_users_cannot_access_the_following_endpoint()
    {
        $this->json("GET", $this->endPoint)->assertStatus(401);

        $this->json("POST", $this->endPoint)->assertStatus(401);

        $this->json("GET", $this->endPoint . "/1")->assertStatus(401);

        $this->json("PUT", $this->endPoint . "/1")->assertStatus(401);

        $this->json("DELETE", $this->endPoint . "/1")->assertStatus(401);
    }
}
