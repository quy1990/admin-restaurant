<?php

namespace App\Providers;

use App\Models\Invitation;
use App\Models\People;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Policies\InvitationPolicy;
use App\Policies\PeoplePolicy;
use App\Policies\ReservationPolicy;
use App\Policies\RestaurantPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Restaurant::class  => RestaurantPolicy::class,
        Invitation::class  => InvitationPolicy::class,
        Reservation::class => ReservationPolicy::class,
        People::class      => PeoplePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensExpireIn(now()->addDays(15));

        Passport::refreshTokensExpireIn(now()->addDays(30));

        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
        //
    }
}
