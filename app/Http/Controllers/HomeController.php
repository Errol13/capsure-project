<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if ($request->routeIs('client-homepage')) {
            // Logic for the client homepage
            return view('client.c_home');
        } elseif ($request->routeIs('freelancer-homepage')) {
            // Logic for the freelancer homepage
            return view('freelancer.f_home');
        } else {
            // Default logic
            return view('home');
        }
    }

    public function showTopServices()
    {
        $users = User::where('user_type', 'freelancer')
            ->with(['freelancer.services', 'freelancer.portfolios'])
            ->orderBy('id')
            ->get();

        return view('client.c_home', compact('users'));
    }
}
