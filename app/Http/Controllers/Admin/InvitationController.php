<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invitation;
use App\Models\User;
use App\Repositories\InvitationRepository;
use App\Repositories\InvitedPeopleRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvitationController extends Controller
{

    private $user;
    public function __construct()
    {
        $this->middleware('auth');
        $this->user = User::find(54);
        //$this->authorizeResource(Invitation::class);
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $user = $this->user;
        $invitations = InvitationRepository::getAll();
        return view("invitation.index", compact("invitations", "user"));
    }


    public function create()
    {
        $user = $this->user;
        return view('invitation.create', compact( "user"));
    }


    public function store(Request $request)
    {
        $user = $this->user;
        InvitationRepository::store($request);
        return redirect()->route('invitations.index');
    }

    public function show(Invitation $invitation)
    {
        $user = $this->user;
        $invitedPeoples = InvitedPeopleRepository::getByInvitation($invitation);
        return view('invitation.show', compact("invitation", "invitedPeoples", "user"));
    }

    public function edit(Invitation $invitation)
    {
        $user = $this->user;
        return view('invitation.show', compact("invitation", "user"));
    }

    public function update(Request $request, $id)
    {
        $user = $this->user;
        InvitationRepository::update($request, $id);
        return redirect()->route('invitations.index', "user");
    }

    public function destroy(Invitation $invitation)
    {
        InvitationRepository::delete($invitation);
        return redirect()->route('invitations.index');
    }

}
