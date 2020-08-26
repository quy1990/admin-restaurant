<?php

namespace App\Providers;

use App\Events\CreateAnInvitationEvent;
use App\Events\CreateAPeopleEvent;
use App\Events\CreateAReservationEvent;
use App\Events\CustomerRemovedInvitationEvent;
use App\Events\CustomerRemovedReservationEvent;
use App\Listeners\SendMailConfirmInvitationListener;
use App\Listeners\SendMailConfirmPeopleListener;
use App\Listeners\SendMailConfirmReservationListener;
use App\Listeners\SendMailRemoveInvitationListener;
use App\Listeners\SendMailRemoveReservationListener;
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
        Registered::class                      => [
            SendEmailVerificationNotification::class,
        ],
        CreateAReservationEvent::class         => [
            SendMailConfirmReservationListener::class,
        ],
        CreateAnInvitationEvent::class         => [
            SendMailConfirmInvitationListener::class,
        ],
        CustomerRemovedReservationEvent::class => [
            SendMailRemoveReservationListener::class,
        ],
        CustomerRemovedInvitationEvent::class  => [
            SendMailRemoveInvitationListener::class,
        ],
        CreateAPeopleEvent::class              => [
            SendMailConfirmPeopleListener::class,
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
