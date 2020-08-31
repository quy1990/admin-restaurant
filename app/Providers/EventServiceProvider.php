<?php

namespace App\Providers;

use App\Events\CommentEvent;
use App\Events\InvitationEvent;
use App\Events\PeopleEvent;
use App\Events\ReservationEvent;
use App\Listeners\SendMailConfirmCommentListener;
use App\Listeners\SendMailConfirmInvitationListener;
use App\Listeners\SendMailConfirmPeopleListener;
use App\Listeners\SendMailConfirmReservationListener;
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
            SendMailConfirmReservationListener::class,
        ],
        InvitationEvent::class  => [
            SendMailConfirmInvitationListener::class,
        ],
        PeopleEvent::class      => [
            SendMailConfirmPeopleListener::class,
        ],
        CommentEvent::class     => [
            SendMailConfirmCommentListener::class,
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
