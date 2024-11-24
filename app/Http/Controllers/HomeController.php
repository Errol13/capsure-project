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
                return view('freelancer.f_home');
            } elseif ($user->user_type == 'admin') {
                // Load admin-specific content
                return redirect()->route('filament.admin.pages.dashboard');
            }
        } else {
            // Load general content for guests

            $freelancers = Freelancer::with('user')->orderBy('avg_rating', 'desc')
                ->orderBy('number_of_projects', 'desc')
                ->take(8)
                ->get();

            return view('welcome', compact('freelancers'));
        }
    }

  
}
