<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Repositories\InvitationRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
class UserController extends Controller
{

    private $user;
    public function __construct()
    {
        $this->middleware('auth');
        $this->user = User::find(54);
        //$this->authorizeResource(User::class);
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $user = $this->user;
        $users = UserRepository::getAll();
        return view("customer.index", compact("users", "user"));
    }

    /**
     * @param User $customer
     * @return Application|Factory|View
     */
    public function show(User $customer)
    {
        $user = $this->user;
        $invitations = InvitationRepository::getByUser($customer);
        return view('customer.show', compact("customer", "invitations", "user"));
    }
}
