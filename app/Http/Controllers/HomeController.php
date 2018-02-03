<?php

namespace App\Http\Controllers;

use App\Holds;
use Illuminate\Support\Facades\DB;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id')->get();
        $holds = Holds::orderBy('id')->get();

        return view('home', ['users' => $users, 'holds' => $holds]);
    }

    /**
     * Add new user
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function add(Request $request) {
        if ($request->name) {
            $user = new User();
            $user->name = $request->name;
            $user->amount = 0;
            $user->save();
        }

        return redirect('/');
    }
}
