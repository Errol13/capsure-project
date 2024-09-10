<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\Profile\CertificatesController;
use App\Http\Controllers\Profile\SettingsController;
use App\Http\Livewire\AddPortfolio;
use App\Http\Livewire\CreateEventForm;
use App\Livewire\CreateEventForm as LivewireCreateEventForm;
use App\Livewire\MyJobs;
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
Route::get('/client-homepage', [App\Http\Controllers\HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('client-homepage');

Route::get('/freelancer-homepage', [App\Http\Controllers\HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('freelancer-homepage');



#Profile
Route::get('/freelancer-profile', [App\Http\Controllers\Profile\ProfileController::class, 'showFreelancersProfile'])->name('freelancer-profile');

Route::get('/client-bookmark', [App\Http\Controllers\Profile\BookmarkController::class, 'showBookMark'])->name('client-bookmark');


#settings
Route::get('/freelancer-settings', [App\Http\Controllers\Profile\SettingsController::class, 'showFreelancerSettings'])->name('freelancer-settings');
Route::patch('/freelancer/profile/update/{id}', [App\Http\Controllers\Profile\SettingsController::class, 'updateFreelancer'])->name('freelancer.update');
Route::patch('/freelancer/services/update/{id}', [App\Http\Controllers\Profile\SettingsController::class, 'updateServices'])->name('service.update');
Route::post('/freelancer/services/add/{id}', [App\Http\Controllers\ServiceController::class, 'addService'])->name('service.add');
Route::delete('/freelancer/services/delete/{service}', [App\Http\Controllers\ServiceController::class, 'deleteService'])->name('service.delete');
Route::patch('/freelancer/terms/update/{id}', [App\Http\Controllers\Profile\SettingsController::class, 'updateTerms'])->name('terms.update');

#socmed
Route::get('/social-media', [App\Http\Controllers\Profile\SocMedController::class, 'showSocMed'])->name('social-media');
Route::patch('/social-media/{platform}/update', [App\Http\Controllers\Profile\SocMedController::class, 'updateSocMed'])->name('social-media.update');

#skills
Route::post('/skills', [SettingsController::class, 'store'])->name('skills.store');
Route::patch('/skills', [SettingsController::class, 'update'])->name('skills.update');
Route::delete('/skills/delete', [SettingsController::class, 'destroy'])->name('skills.destroy');

#certificates
Route::post('/certificates', [App\Http\Controllers\Profile\CertificateController::class, 'store'])->name('certificates.store');
Route::patch('/certificates/update', [App\Http\Controllers\Profile\CertificateController::class, 'update'])->name('certificates.update');
Route::delete('/certificates/delete', [App\Http\Controllers\Profile\CertificateController::class, 'destroy'])->name('certificates.destroy');

#portfolio 
Route::post('/freelancer/portfolio/add/{id}', [App\Http\Controllers\Profile\PortfolioController::class, 'addPortfolio'])->name('portfolio.add');
Route::post('/delete/image', [App\Http\Controllers\Profile\PortfolioController::class, 'deleteImage'])->name('delete.image');
Route::delete('/delete-album', [App\Http\Controllers\Profile\PortfolioController::class, 'deleteAlbum'])->name('delete-album');

#My Events Page Client
Route::get('/events', [App\Http\Controllers\Hiring\EventsController::class, 'showEventsForm'])->name('events');
Route::get('client-events', [App\Http\Controllers\Hiring\EventsController::class, 'showMyEvents'])->name('client-events');
Route::get('client-viewpost/{id}', [App\Http\Controllers\Hiring\EventsController::class, 'showViewPost'])->name('client-viewpost');

#Job Application
Route::post('apply-job', [App\Http\Controllers\Hiring\Job_applicationController::class, 'applyJob'])->name('job.apply');
Route::patch('apply-job/reject/{id}', [App\Http\Controllers\Hiring\Job_applicationController::class, 'rejectApplicant'])->name('jobApplication.update');
Route::patch('event/close/{id}', [App\Http\Controllers\Hiring\EventsController::class, 'closeEventPost'])->name('eventpost.close');

#Transaction
Route::get('client-transaction', [App\Http\Controllers\Transaction\ClientTransactController::class, 'showClientTransact'])->name('client-transaction');

#My Jobs Page
Route::get('/my-jobs', [FreelancerController::class, 'myJobs'])->name('my-jobs');

#hiring requests
Route::post('/hire/applicant', [App\Http\Controllers\Hiring\Hiring_requestController::class, 'hireFreelancer'])->name('freelancer.hire');

#Validation
Route::get('validphone', [App\Http\Controllers\Validation\ValidateController::class, 'showValidPhone'])->name('validphone');
