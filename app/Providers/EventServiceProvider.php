<?php

namespace App\Providers;

use App\Events\CustomerInvitedEvent;
use App\Events\CustomerInvitedPeopleEvent;
use App\Events\CustomerRemovedInvitationEvent;
use App\Events\CustomerRemovedReservationEvent;
use App\Events\CustomerReservedEvent;
use App\Listeners\SendMailConfirmReservationListener;
use App\Listeners\SendMailInvitationToInvitorListener;
use App\Listeners\SendMailToInvitedPeopleListener;
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
        CustomerReservedEvent::class           => [
            SendMailConfirmReservationListener::class,
        ],
        CustomerInvitedEvent::class            => [
            SendMailInvitationToInvitorListener::class,
        ],
        CustomerRemovedReservationEvent::class => [
            SendMailRemoveReservationListener::class,
        ],
        CustomerRemovedInvitationEvent::class  => [
            SendMailRemoveInvitationListener::class,
        ],
        CustomerInvitedPeopleEvent::class      => [
            SendMailToInvitedPeopleListener::class,
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
