<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

#User Auth Routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/choose', [App\Http\Controllers\ChooseController::class, 'index'])->name('choose');

Route::get('/client-homepage', [App\Http\Controllers\HomeController::class, 'index'])->name('client-homepage');