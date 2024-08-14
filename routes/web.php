<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false,  // Disable default registration route
    'verify' => true      // Enable email verification routes
]);

// Custom registration routes
Route::get('/register/client', [RegisterController::class, 'showClientRegisterForm'])->name('register.client');
Route::get('/register/freelancer', [RegisterController::class, 'showFreelancerRegisterForm'])->name('register.freelancer');

Route::post('/register/client', [RegisterController::class, 'registerClient'])->name('register.client.post');
Route::post('/register/freelancer', [RegisterController::class, 'registerFreelancer'])->name('register.freelancer.post');

#User Auth Routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/choose', [App\Http\Controllers\ChooseController::class, 'index'])->name('choose');

#Homepages
Route::get('/client-homepage', [App\Http\Controllers\HomeController::class, 'index'])->name('client-homepage') ->middleware(['auth', 'verified']);
Route::get('/freelancer-homepage', [App\Http\Controllers\HomeController::class, 'index'])->name('freelancer-homepage') ->middleware(['auth', 'verified']);

#Profile
Route::get('/client-bookmark', [App\Http\Controllers\Profile\BookmarkController::class, 'showBookMark'])->name('client-bookmark');

#Profile Pages
Route::get('/freelancer-profile', [App\Http\Controllers\Profile\ProfileController::class, 'showFreelancersProfile'])->name('freelancer-profile');
