<?php

namespace App\Http\Controllers\Hiring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function showEventsForm(){
        return view('client.createEvent');
    }

    public function showMyEvents(){
        return view('client.c_myEvents');
    }
}
