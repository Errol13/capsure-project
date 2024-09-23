<?php


namespace App\Http\Controllers\Profile;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    //

    public function showFreelancersProfile(){
      /** @var User $user */
      $user = Auth::user();
      $fullName = "{$user->first_name} {$user->last_name}";

      if ($user->user_type == 'freelancer') {
          // Load related data for freelancers
          $user->load('freelancer.services', 'freelancer.certificates', 'freelancer.portfolios', 'freelancer.reviews.transaction.event');

          //get the freelancer's reviews made by the clients
          $reviews = $user->freelancer->reviews()->where('reviewee_role', 'freelancer')->paginate(4);
          return view('freelancer.f_profile', compact('user','fullName', 'reviews'));
      } elseif ($user->user_type == 'client') {
          // Load related data for clients
          $user->load('client');
          return view('client.c_profile', compact('user')); // No view created yet
      }

    }
    public function showClientsProfile(){
        return view('client.c_profile');
      }
}
