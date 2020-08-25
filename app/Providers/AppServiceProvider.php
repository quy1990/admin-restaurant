<?php

namespace App\Providers;

use App\Models\Invitation;
use App\Models\ModelObservers\InvitationObserver;
use App\Models\ModelObservers\PeopleObserver;
use App\Models\ModelObservers\ReservationObserver;
use App\Models\ModelObservers\UserObserver;
use App\Models\People;
use App\Models\Reservation;
use App\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(new UserObserver);
        Reservation::observe(new ReservationObserver);
        Invitation::observe(new InvitationObserver);
        People::observe(new PeopleObserver);
    }
}
