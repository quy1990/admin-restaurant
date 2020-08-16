<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::get('logout', 'AuthController@logout');
});

Route::group(['middleware' => 'auth:api', "namespace" => "api"], function () {
    Route::resources([
        'restaurants'    => 'RestaurantController',
        'reservations'   => 'ReservationController',
        'invitations'    => 'InvitationController',
        'invitedpeoples' => 'InvitedPeopleController',
    ]);

    Route::group(['prefix' => 'users'], function () {
        Route::get('{user}/restaurants',
            'UserController@getRestaurants');

        Route::get('{user}/reservation',
            'UserController@getReservation');

        Route::get('{user}/invitation',
            'UserController@getInvitation');
    });

    Route::group(['prefix' => 'restaurants'], function () {
        Route::get('{restaurant}/reservations',
            'RestaurantController@getReservations');

        Route::get('{restaurant}/owners',
            'RestaurantController@getOwners');

        Route::get('{restaurant}/invitations',
            'RestaurantController@getInvitations');
    });

    Route::group(['prefix' => 'reservations'], function () {
        Route::get('{reservation}/restaurant',
            'ReservationController@getRestaurant');

        Route::get('{reservation}/user',
            'ReservationController@getUser');

        Route::get('{reservation}/invitations',
            'ReservationController@getInvitations');
    });

    Route::group(['prefix' => 'invitations'], function () {
        Route::get('{invitation}/restaurant',
            'InvitationController@getRestaurant');

        Route::get('{invitation}/user',
            'InvitationController@getUser');

        Route::get('{invitation}/reservation',
            'InvitationController@getReservation');
    });

    //logout
    Route::get('logout', 'AuthController@logout');
});
