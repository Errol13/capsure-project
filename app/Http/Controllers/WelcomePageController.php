<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use App\Models\Hiring\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomePageController extends Controller
{
    //

    public function showWelcomePage()
    {
        if(Auth::check()){
            $user = Auth::user();
            if($user->user_type === 'client' || $user->user_type === 'freelancer'){
                return redirect('/home');
            } elseif($user->user_type === 'admin'){
                return redirect()->route('filament.admin.pages.dashboard');
            }
           
        }
        $freelancers = Freelancer::with(['user', 'services'])->orderBy('avg_rating', 'desc')
            ->orderBy('number_of_projects', 'desc')
            ->orderBy('user_id', 'asc')
            ->take(12)
            ->get();

        $events = Event::with(['client.user'])->where('status', 'Open')->orderBy('budget_max', 'desc')
            ->take(3)
            ->get();

        return view('welcome', compact('freelancers', 'events'));
    }
}
