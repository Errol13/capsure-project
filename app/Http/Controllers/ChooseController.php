<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChooseController extends Controller
{
    public function index()
    {
        return view('sign_up_choose'); // returns the sign up choose blade view
    }
}
