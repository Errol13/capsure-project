<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->user_type == 'client') {
                // Load client-specific content
                $users = User::where('user_type', 'freelancer')
                    ->with(['freelancer.services', 'freelancer.portfolios'])
                    ->orderBy('id')
                    ->paginate(9);
                return view('client.c_home', compact('users'));
            } elseif ($user->user_type == 'freelancer') {
                // Load freelancer-specific content
                $users = User::where('user_type', 'client')
                    ->whereHas('client.events')
                    ->with(['client.events', 'events.event_jobs'])
                    ->orderBy('id')
                    ->paginate(9);
                return view('freelancer.f_home', compact('users'));
            } elseif ($user->user_type == 'admin') {
                // Load admin-specific content
                return view('admin.dashboard');
            }
        } else {
            // Load general content for guests
            return view('welcome');
        }
    }
}
