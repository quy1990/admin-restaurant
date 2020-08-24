<?php

namespace App\Providers;

use App\Events\CustomerInviteEvent;
use App\Events\CustomerRemoveInviteEvent;
use App\Events\CustomerRemoveReserveEvent;
use App\Events\CustomerReserveEvent;
use App\Listeners\SendMailConfirmInvitationListener;
use App\Listeners\SendMailConfirmReservationListener;
use App\Listeners\SendMailRemoveInvitationListener;
use App\Listeners\SendMailRemoveReservationListener;
use App\Models\Invitation;
use App\Models\ModelObservers\InvitationObserver;
use App\Models\ModelObservers\ReservationObserver;
use App\Models\ModelObservers\UserObserver;
use App\Models\Reservation;
use App\User;
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
        Registered::class                 => [
            SendEmailVerificationNotification::class,
        ],
        CustomerReserveEvent::class       => [
            SendMailConfirmReservationListener::class,
        ],
        CustomerInviteEvent::class        => [
            SendMailConfirmInvitationListener::class,
        ],
        CustomerRemoveReserveEvent::class => [
            SendMailRemoveReservationListener::class,
        ],
        CustomerRemoveInviteEvent::class  => [
            SendMailRemoveInvitationListener::class,
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

        User::observe(new UserObserver);
        Reservation::observe(new ReservationObserver);
        Invitation::observe(new InvitationObserver);
        //
    }
}
