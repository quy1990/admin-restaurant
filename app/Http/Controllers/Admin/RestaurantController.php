<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;
use App\Repositories\ReservationRepository;
use App\Repositories\RestaurantRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RestaurantController extends Controller
{

    private $user;

    public function __construct()
    {
        $this->user = Auth::user();
        //dd($this->user);
        //$this->authorizeResource(Restaurant::class);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $user = $this->user;
        $restaurants = RestaurantRepository::getAll($request);
        return view("restaurant.index", compact("restaurants", "user"));
    }


    public function create()
    {
        $user = $this->user;
        return view('restaurant.create', compact( "user"));
    }


    public function store(Request $request)
    {
        $user = $this->user;
        app(RestaurantRepository::class)->store($request, $user);
        return redirect()->route('restaurants.index');
    }

    public function show(Restaurant $restaurant)
    {
        $user = $this->user;
        $reservations =app(RestaurantRepository::class)->getReservations($restaurant);
        return view('restaurant.show', compact("restaurant", "reservations", "user"));
    }

    public function edit(Restaurant $restaurant)
    {
        $user = $this->user;
        return view('restaurant.show', compact("restaurant", "user"));
    }

    public function update(Request $request, $id)
    {
        $user = $this->user;
        RestaurantRepository::update($request, $id);
        return redirect()->route('restaurants.index', "user");
    }

    public function destroy(Restaurant $restaurant)
    {
        RestaurantRepository::delete($restaurant);
        return redirect()->route('restaurants.index');
    }

    public function showInvoice()
    {
        $user = $this->user;
        return view("restaurant.invoice", "user");
    }


    public function showCustomer()
    {
        $user = $this->user;
        return view("restaurant.customer", "user");
    }

    public function showPlan()
    {
        $user = $this->user;
        return view("restaurant.plan", "user");
    }


    public function showChart()
    {
        $user = $this->user;
        return view("restaurant.chart", "user");
    }

    public function showMedia()
    {
        $user = $this->user;
        return view("restaurant.media", "user");
    }


}
