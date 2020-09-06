<?php

namespace App\Providers;

use App\Events\CommentEvent;
use App\Events\InvitationEvent;
use App\Events\PeopleEvent;
use App\Events\ReservationEvent;
use App\Listeners\CommentListener;
use App\Listeners\InvitationListener;
use App\Listeners\PeopleListener;
use App\Listeners\ReservationListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class       => [
            SendEmailVerificationNotification::class,
        ],
        ReservationEvent::class => [
            ReservationListener::class,
        ],
        InvitationEvent::class  => [
            InvitationListener::class,
        ],
        PeopleEvent::class      => [
            PeopleListener::class,
        ],
        CommentEvent::class     => [
            CommentListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
