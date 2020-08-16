<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view("backend.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view("restaurants.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        return view("backend.user");
    }


    /**
     * Display the specified resource.
     *
     * @return Application|Factory|View
     */
    public function showInvoice()
    {
        return view("backend.invoice");
    }

    /**
     * Display the specified resource.
     *
     * @return Application|Factory|View
     */
    public function showCustomer()
    {
        return view("backend.customer");
    }

    /**
     * Display the specified resource.
     *
     * @return Application|Factory|View
     */
    public function showPlan()
    {
        return view("backend.plan");
    }

    /**
     * Display the specified resource.
     *
     * @return Application|Factory|View
     */
    public function showChart()
    {
        return view("backend.chart");
    }

    /**
     * Display the specified resource.
     *
     * @return Application|Factory|View
     */
    public function showMedia()
    {
        return view("backend.media");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     */
    public function destroy($id)
    {
        //
    }
}
