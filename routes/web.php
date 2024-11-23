<?php

use App\Filament\Resources\Profile\VerificationResource;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Profile\CertificatesController;
use App\Http\Controllers\Profile\SettingsController;
use App\Http\Controllers\WelcomePageController;
use App\Http\Livewire\AddPortfolio;
use App\Http\Livewire\CreateEventForm;
use App\Http\Middleware\CheckSuspendedUser;
use App\Livewire\ClientHome;
use App\Livewire\MyJobs;
use App\Livewire\ShowServices;
use App\Models\Profile\Verification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', [WelcomePageController::class, 'showWelcomePage'])->name('welcome');

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



#suspended middleware
Route::middleware([CheckSuspendedUser::class])->group(function () {

    #Homepages
    Route::get('/client-homepage', [App\Http\Controllers\HomeController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('client-homepage');

    Route::get('/freelancer-homepage', [App\Http\Controllers\HomeController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('freelancer-homepage');

    #Profile
    Route::get('/freelancer-profile', [App\Http\Controllers\Profile\ProfileController::class, 'showFreelancersProfile'])->name('freelancer-profile');
    Route::get('/client-profile', [App\Http\Controllers\Profile\ProfileController::class, 'showClientsProfile'])->name('client-profile');
    Route::get('/client-bookmark', [App\Http\Controllers\Profile\BookmarkController::class, 'showBookMark'])->name('client-bookmark');
    Route::get('/team-profile', [App\Http\Controllers\Profile\ProfileController::class, 'showTeamProfile'])->name('team-profile');
    Route::get('/view/freelancer-profile/{id}', [App\Http\Controllers\Profile\ProfileController::class, 'viewFreelancerProfile'])->name('view-freelancer-profile');
    Route::get('/view/client-profile/{id}', [App\Http\Controllers\Profile\ProfileController::class, 'viewClientProfile'])->name('view-client-profile');
    Route::get('/profile/getselectedevents/{id}', [App\Http\Controllers\Profile\ProfileController::class, 'findSelectedEvent'])->name('find-event-from-profile');

    #profie-pic
    Route::post('/profilepic/update', [App\Http\Controllers\Profile\ProfileController::class, 'updateProfilePic'])->name('profilepic.update');

    #viewAllReviews
    Route::get('/see/allreviews', [App\Http\Controllers\Profile\ProfileController::class, 'showAllReviews'])->name('allReviews.show');

    #seeAllPosts
    Route::get('/see/client/allposts/{id}', [App\Http\Controllers\Profile\ProfileController::class, 'showAllPosts'])->name('allPosts.show');

    #bookmark
    Route::post('/favorites/add/{freelancer}', [App\Http\Controllers\Profile\BookmarkController::class, 'addFavorite'])->name('favorites.add');
    Route::delete('/favorites/remove/{freelancer}', [App\Http\Controllers\Profile\BookmarkController::class, 'removeFavorite'])->name('favorites.remove');
    Route::post('/client-bookmark/save/{id}', [App\Http\Controllers\Profile\BookmarkController::class, 'bookmarkFreelancer'])->name('bookmark.save');


    #settings(freelancer)
    Route::get('/freelancer-settings', [App\Http\Controllers\Profile\SettingsController::class, 'showFreelancerSettings'])->name('freelancer-settings');
    Route::patch('/freelancer/profile/update/{id}', [App\Http\Controllers\Profile\SettingsController::class, 'updateFreelancer'])->name('freelancer.update');
    Route::patch('/freelancer/services/update/{id}', [App\Http\Controllers\Profile\SettingsController::class, 'updateServices'])->name('service.update');
    Route::post('/freelancer/services/add/{id}', [App\Http\Controllers\ServiceController::class, 'addService'])->name('service.add');
    Route::delete('/freelancer/services/delete/{service}', [App\Http\Controllers\ServiceController::class, 'deleteService'])->name('service.delete');
    Route::patch('/freelancer/terms/update/{id}', [App\Http\Controllers\Profile\SettingsController::class, 'updateTerms'])->name('terms.update');


    Route::get('/client-settings', [App\Http\Controllers\Profile\SettingsController::class, 'showClientSettings'])->name('client-settings');
    Route::get('/freelancer-freelancer', [App\Http\Controllers\Profile\SettingsController::class, 'showBeFreelancer'])->name('freelancer-freelancer');

    #settings(client)
    Route::patch('/client/profile/update/{id}', [App\Http\Controllers\Profile\SettingsController::class, 'updateClientInfo'])->name('client.update');

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
    Route::post('/delete/portfolio/files', [App\Http\Controllers\Profile\PortfolioController::class, 'deleteFiles'])->name('files.delete');
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
    Route::get('client-transaction', [App\Http\Controllers\Transaction\TransactionController::class, 'showClientTransact'])->name('client-transaction');
    Route::get('freelancer-transaction', [App\Http\Controllers\Transaction\TransactionController::class, 'showFreelancerTransact'])->name('freelancer-transaction');

    #Chat
    Route::get('/chat/{conversationId?}', [App\Http\Controllers\Profile\ProfileController::class, 'showChat'])->name('show-chat')->middleware('auth');
    Route::post('/chat/redirect', [App\Http\Controllers\Profile\ProfileController::class, 'redirectToChat'])->name('chat.redirect')->middleware('auth');

    #Report 
    Route::post('/report', [App\Http\Controllers\Profile\ProfileController::class, 'reportStore'])->name('report.store')->middleware('auth');

    #My Jobs Page
    Route::get('/my-jobs', [FreelancerController::class, 'myJobs'])->name('my-jobs');

    #hiring requests
    Route::post('/hire/applicant', [App\Http\Controllers\Hiring\Hiring_requestController::class, 'hireFreelancer'])->name('freelancer.hire');
    Route::patch('/hire/negotiate', [App\Http\Controllers\Hiring\Hiring_requestController::class, 'negotiatePrice'])->name('freelancer.negotiate');
    Route::patch('/hire/offer/cancel/{id}', [App\Http\Controllers\Hiring\Hiring_requestController::class, 'cancelOffer'])->name('offer.cancel');
    Route::patch('/hire/offer/decline/{id}', [App\Http\Controllers\Hiring\Hiring_requestController::class, 'declineOffer'])->name('offer.decline');
    Route::post('/hire/offer/accept/{id}', [App\Http\Controllers\Hiring\Hiring_requestController::class, 'acceptOffer'])->name('offer.accept');

    #payment proof
    Route::post('/transaction/paymentproof/upload/{id}', [App\Http\Controllers\Transaction\PaymentProofController::class, 'uploadPaymentProof'])->name('payment.upload');
    Route::patch('/transaction/paymentproof/confirm/{id}', [App\Http\Controllers\Transaction\PaymentProofController::class, 'confirmPayment'])->name('payment.confirm');

    #review 
    Route::post('/transaction/review/write/{id}', [App\Http\Controllers\Transaction\ReviewController::class, 'writeReview'])->name('submit.review');

    #Validation
    Route::get('validphone', [App\Http\Controllers\Validation\ValidateController::class, 'showValidPhone'])->name('validphone');
    Route::get('validID', [App\Http\Controllers\Validation\ValidateController::class, 'showValidID'])->name('validID');
    Route::post('/validate-id/store', [App\Http\Controllers\Validation\ValidateController::class, 'validateIdStore'])->name('validate.id');
});

#Suspension
Route::get('/suspended', function () {
    return view('suspended_notice'); // A view that informs the user they are suspended
})->name('suspended');
