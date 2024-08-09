<?php

namespace App\Http\Controllers;

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
        return view('client.c_homepage');
    } else {
        // Default logic 
        return view('home');
    }
}
}