<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientTransactController extends Controller
{
    public function showClientTransact(){
        return view('client.c_myTransaction');
        }
}
