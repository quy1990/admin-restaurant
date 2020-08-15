<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->namespace('admin')->group(function () {
    Route::resources([
        //'/'               => 'HomeController',
        '/'               => 'RestaurantController',
        'restaurants'     => 'RestaurantController',
        'reservations'    => 'ReservationController',
        'invitations'     => 'InvitationController',
        'invited_peoples' => 'InvitedPeopleController',
    ]);
    // GET RELATIONS BETWEEN TABLES
    // get reservations of restaurant
    Route::get('restaurants/{restaurant}/reservations',
        'RestaurantController@getReservations');

    // get reservations of restaurant
    Route::get('restaurants/reservations',
        'RestaurantController@getReservations');
});

