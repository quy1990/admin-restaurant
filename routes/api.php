<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::get('logout', 'AuthController@logout');
});

Route::group(['middleware' => 'auth:api', "namespace" => "Api\\v1", "prefix" => "v1"], function () {
    Route::resources([
        'restaurants'  => 'RestaurantController',
        'reservations' => 'ReservationController',
        'invitations'  => 'InvitationController',
        'peoples'      => 'PeopleController',
        'categories'   => 'CategoryController',
        'comments'     => 'CommentController',
        'tags'         => 'TagController',
        'images'       => 'ImageController',
    ]);

    Route::group(['prefix' => 'users'], function () {
        Route::get('{user}/visited-restaurants',
            'UserController@getVisitedRestaurants');

        Route::get('{user}/restaurants',
            'UserController@getOwnedRestaurants');

        Route::get('{user}/reservations',
            'UserController@getReservations');

        Route::get('{user}/invitations',
            'UserController@getInvitations');
        Route::get('{user}/peoples',
            'UserController@getPeoples');
    });

    Route::group(['prefix' => 'restaurants'], function () {
        Route::get('{restaurant}/reservations',
            'RestaurantController@getReservations');

        Route::get('{restaurant}/owners',
            'RestaurantController@getOwners');

        Route::get('{restaurant}/categories',
            'RestaurantController@getCategories');

        Route::get('{restaurant}/tags',
            'RestaurantController@getTags');

        Route::get('{restaurant}/images',
            'RestaurantController@getImages');

        Route::get('{restaurant}/comments',
            'RestaurantController@getComments');
    });

    Route::group(['prefix' => 'reservations'], function () {
        Route::get('{reservation}/restaurant',
            'ReservationController@getRestaurant');

        Route::get('{reservation}/user',
            'ReservationController@getUser');

        Route::get('{reservation}/invitations',
            'ReservationController@getInvitations');

        Route::get('{reservation}/peoples',
            'ReservationController@getPeoples');
    });

    Route::group(['prefix' => 'invitations'], function () {
        Route::get('{invitation}/restaurant',
            'InvitationController@getRestaurant');

        Route::get('{invitation}/user',
            'InvitationController@getUser');

        Route::get('{invitation}/reservation',
            'InvitationController@getReservation');

        Route::get('{invitation}/peoples',
            'InvitationController@getPeoples');
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('{category}/restaurants',
            'CategoryController@getRestaurants');
    });

    Route::group(['prefix' => 'tags'], function () {
        Route::get('{tag}/restaurants',
            'TagController@getRestaurants');
    });

    Route::group(['prefix' => 'images'], function () {
        Route::get('{image}/restaurants',
            'ImageController@getRestaurants');
    });
});
