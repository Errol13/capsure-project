<?php

namespace App\Http\Controllers\Validation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValidateController extends Controller
{
    public function showValidPhone(){
        return view('validation.validphone');
        }

    public function showValidID(){
        return view('validation.validID');
        }
}
