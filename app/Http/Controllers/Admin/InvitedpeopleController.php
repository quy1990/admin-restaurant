<?php

namespace App\Http\Controllers\Admin;

use App\Models\People;
use App\Models\Reservation;
use App\Models\User;
use App\Repositories\PeopleRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvitedpeopleController extends Controller
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
        $invitedPeoples = PeopleRepository::getAll();
        return view("invitedPeople.index", compact("invitedPeoples", "user"));
    }


    public function create()
    {
        $user = $this->user;
        return view('invitedPeople.create', compact( "user"));
    }


    public function store(Request $request)
    {
        $user = $this->user;
        PeopleRepository::store($request);
        return redirect()->route('invitedPeoples.index');
    }

    public function show(People $invitedPeople)
    {
        $user = $this->user;
        return view('invitedPeople.show', compact("invitedPeople", "user"));
    }

    public function edit(People $invitedPeople)
    {
        $user = $this->user;
        return view('invitedPeople.show', compact("invitedPeople", "user"));
    }

    public function update(Request $request, $id)
    {
        $user = $this->user;
        PeopleRepository::update($request, $id);
        return redirect()->route('invitedPeople.index', "user");
    }

    public function destroy(People $invitedPeople)
    {
        PeopleRepository::delete($invitedPeople);
        return redirect()->route('invitedPeople.index');
    }

}
