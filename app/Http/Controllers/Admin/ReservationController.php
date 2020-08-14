<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\RestaurantRepository;
use App\Repositories\ReservationRepository;
use  App\Http\Requests\ReservationRequest;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("reservations.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("reservations.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationRequest $request)
    {
        $customer = Customer::firstOrCreate([
            "email" => $request->get("email"),
        ]);

        $order = new Order;
        $order->customer_id = $customer->id;
        $order->save();

        $restaurant = Restaurant::find(1);

        $restaurant->orders()->attach($order, [
            'number_people' =>  $request->get("number_people"),
            'booking_time' =>  $request->get("date")." ".$request->get("time").":00",
        ]);
        return redirect("/");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $restaurant_id  = 1;
        $restaurant     = RestaurantRepository::get($restaurant_id);
        $reservation    = ReservationRepository::get($id);
        return view("reservations.show", compact("reservation","restaurants"));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $number_people  = $request->get("number_people");
        $booking_time   = $request->get("booking_time");

        $reservation = ReservationRepository::get($id)->update([
            "number_people" => $number_people,
            "booking_time"  => $booking_time,
        ]);
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = ReservationRepository::delete($id);
        return redirect('/');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showInvoice()
    {
        return view("backend.invoice");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showCustomer()
    {
        return view("backend.customer");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showPlan()
    {
        return view("backend.plan");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showChart()
    {
        return view("backend.chart");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMedia()
    {
        return view("backend.media");
    }
}
