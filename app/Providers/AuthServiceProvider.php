<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model\Restaurant' => 'App\Policies\RestaurantPolicy',
        'App\Model\Invitation' => 'App\Policies\InvitationPolicy',
        'App\Model\InvitedPeople' => 'App\Policies\InvitedPeoplePolicy',
        'App\Model\Reservation' => 'App\Policies\ReservationPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
