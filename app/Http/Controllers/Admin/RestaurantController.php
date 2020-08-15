<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;
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
        //$this->authorizeResource(Restaurant::class);
        $this->user = Auth::user();
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $restaurants = RestaurantRepository::getAll();
        return view("restaurant.index", compact("restaurants"));
    }


    public function create()
    {
        return view('restaurant.create');
    }


    public function store(Request $request)
    {
        RestaurantRepository::store($request, $this->user);
        return redirect()->action('RestaurantController@index');
    }

    public function show(Restaurant $restaurant)
    {
        return view('restaurant.show', compact("restaurant"));
    }

    public function edit(Restaurant $restaurant)
    {
        //
    }

    public function update(Request $request, $id)
    {
        RestaurantRepository::update($request, $id);
        return redirect()->route('restaurants.index');
    }

    public function destroy(Restaurant $restaurant)
    {

    }

    public function showInvoice()
    {
        return view("backend.invoice");
    }


    public function showCustomer()
    {
        return view("backend.customer");
    }

    public function showPlan()
    {
        return view("backend.plan");
    }


    public function showChart()
    {
        return view("backend.chart");
    }

    public function showMedia()
    {
        return view("backend.media");
    }


}
