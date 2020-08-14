<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct()
    {

    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('home');
    }
}
