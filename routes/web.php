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

Auth::routes();

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => 'auth:web', "namespace" => "Admin", "prefix" => "admin"], function () {
    Route::resources([
        '/'              => 'RestaurantController',
        'restaurants'    => 'RestaurantController',
        'reservations'   => 'ReservationController',
        'invitations'    => 'InvitationController',
        'invitedpeoples' => 'InvitedpeopleController',
        'customers'      => 'UserController',
    ]);
});

