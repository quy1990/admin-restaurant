<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->namespace('Api')->group(function (){
    Route::resources([
        'restaurants'       => 'RestaurantController',
        'reservations'      => 'ReservationController',
        'invitations'       => 'InvitationController',
        'invited_peoples'   => 'InvitedPeopleController',
    ]);

// GET RELATIONS BETWEEN TABLES
    // get reservations of restaurant
    Route::get('restaurants/{restaurant}/reservations',
        'RestaurantController@getReservations');

    // get all restaurants are owned by user
    Route::get('users/restaurants',
        'UserController@getRestaurants');

    // get reservations of user
    Route::get('users/reservations',
        'UserController@getReservations');

    // get reservations of restaurant
    Route::get('restaurants/reservations',
        'RestaurantController@getReservations');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
