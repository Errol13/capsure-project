<?php

namespace App\Http\Controllers;

use App\Models\Freelancer;
use App\Models\Hiring\Event;
use Illuminate\Http\Request;

class WelcomePageController extends Controller
{
    //

    public function showWelcomePage()
    {
        $freelancers = Freelancer::with(['user', 'services'])->orderBy('avg_rating', 'desc')
            ->orderBy('number_of_projects', 'desc')
            ->orderBy('user_id', 'asc')
            ->take(8)
            ->get();

        $events = Event::with(['client.user'])->where('status', 'Open')->orderBy('budget_max', 'desc')
            ->take(8)
            ->get();

        return view('welcome', compact('freelancers', 'events'));
    }
}
