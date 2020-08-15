<?php

namespace App\Http\Controllers\Admin;

use App\Models\Reservation;
use App\Models\User;
use App\Repositories\ReservationRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
class ReservationController extends Controller
{

    private $user;
    public function __construct()
    {
        $this->middleware('auth');
        $this->user = User::find(54);
        //$this->authorizeResource(Reservation::class);
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $user = $this->user;
        $reservations = ReservationRepository::getAll();
        return view("reservation.index", compact("reservations", "user"));
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $user = $this->user;
        return view('reservation.create', compact( "user"));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $user = $this->user;
        ReservationRepository::store($request, $user);
        return redirect()->route('reservation.index');
    }

    /**
     * @param Reservation $reservation
     * @return Application|Factory|View
     */
    public function show(Reservation $reservation)
    {
        $user = $this->user;
        return view('reservation.show', compact("reservation", "user"));
    }

    /**
     * @param Reservation $reservation
     * @return Application|Factory|View
     */
    public function edit(Reservation $reservation)
    {
        $user = $this->user;
        return view('reservation.show', compact("reservation", "user"));
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = $this->user;
        ReservationRepository::update($request, $id);
        return redirect()->route('reservation.index', "user");
    }

    /**
     * @param Reservation $reservation
     * @return RedirectResponse
     */
    public function destroy(Reservation $reservation)
    {
        ReservationRepository::delete($reservation);
        return redirect()->route('reservation.index');
    }

}
