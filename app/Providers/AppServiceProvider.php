<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Invitation;
use App\Models\People;
use App\Models\Reservation;
use App\Observers\CommentObserver;
use App\Observers\InvitationObserver;
use App\Observers\PeopleObserver;
use App\Observers\ReservationObserver;
use App\Observers\UserObserver;
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
        Reservation::observe($this->app->make(ReservationObserver::class));
        User::observe($this->app->make(UserObserver::class));
        Invitation::observe($this->app->make(InvitationObserver::class));
        People::observe($this->app->make(PeopleObserver::class));
        Comment::observe($this->app->make(CommentObserver::class));
    }
}
