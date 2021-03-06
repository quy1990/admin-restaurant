<?php

namespace Tests\Unit;

use App\Models\Invitation;
use App\Models\Reservation;
use App\Models\People;
use App\Models\Restaurant;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class InvitationTest
 * docker exec -it app ./vendor/bin/phpunit --filter InvitationTest
 */
class InvitationTest extends TestCase
{
    use RefreshDatabase;

    /*
     * Run All TestCase
     * docker exec -it app ./vendor/bin/phpunit
     * */

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter a_user_made_reservations_invitations
     * @test
     */
    public function a_user_made_reservations_invitations()
    {
        $user = factory(User::class)->create();

        $restaurant = factory(Restaurant::class)->create();

        $reservation = factory(Reservation::class)->create([
            'restaurant_id' => $restaurant->id,
            'user_id'       => $user->id
        ]);

        $invitation = factory(Invitation::class)->create([
            'reservation_id' => $reservation->id
        ]);

        factory(People::class, 20)->create([
            'invitation_id' => $invitation->id
        ]);

        $this->assertGreaterThan(0, $user->reservations->count());;
    }

    /**
     * docker exec -it app ./vendor/bin/phpunit --filter a_restaurant_has_reservations_invitations
     * @test
     */
    public function a_restaurant_has_reservations_invitations()
    {
        $user = factory(User::class)->create();
        $restaurant = factory(Restaurant::class)->create();
        $user->ownedRestaurants()->sync($restaurant->id);

        $reservation = factory(Reservation::class)->create([
            'restaurant_id' => $restaurant->id,
            'user_id'       => $user->id
        ]);

        $invitation = factory(Invitation::class)->create([
            'reservation_id' => $reservation->id,
            'restaurant_id' => $restaurant->id,
            'user_id'       => $user->id
        ]);

        $invitedPeoples = factory(People::class, 30)->create([
            'invitation_id' => $invitation->id,
            'restaurant_id' => $restaurant->id,
            'user_id'       => $user->id
        ]);
        $this->assertTrue(in_array($reservation->id, $restaurant->reservations->pluck('id')->toArray()));
        $this->assertGreaterThan(0, $invitation->peoples->count());

        return [
            'user'           => $user,
            'restaurant'     => $restaurant,
            'reservation'    => $reservation,
            'invitation'     => $invitation,
            'invitedPeoples' => $invitedPeoples,
        ];
    }

}
