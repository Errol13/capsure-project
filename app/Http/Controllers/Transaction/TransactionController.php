<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function showClientTransact()
    {
        return view('client.c_myTransaction');
    }
    public function showFreelancerTransact()
    {
        return view('freelancer.f_myTransaction');
    }
}
