<?php


namespace App\Http\Controllers\Profile;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
  //

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 32086fbf9ce339f269106a55befb686bbdc59e9e
  public function showFreelancersProfile()
  {
    /** @var User $user */
    $user = Auth::user();
    $fullName = "{$user->first_name} {$user->last_name}";
<<<<<<< HEAD

    if ($user->user_type == 'freelancer') {
      // Load related data for freelancers
      $user->load('freelancer.services', 'freelancer.certificates', 'freelancer.portfolios', 'freelancer.reviews.transaction.event');

      //get the freelancer's reviews made by the clients
      $reviews = $user->freelancer->reviews()->where('reviewee_role', 'freelancer')->paginate(4);
      return view('freelancer.f_profile', compact('user', 'fullName', 'reviews'));
=======
=======
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
>>>>>>> 5fd78aa4d533e55c45f59a7fd38ef9958d9f1ff6

    if ($user->user_type == 'freelancer') {
      // Load related data for freelancers
      $user->load('freelancer.services', 'freelancer.certificates', 'freelancer.portfolios');
      return view('freelancer.f_profile', compact('user', 'fullName'));
>>>>>>> 32086fbf9ce339f269106a55befb686bbdc59e9e
    } elseif ($user->user_type == 'client') {
      // Load related data for clients
      $user->load('client');
      return view('client.c_profile', compact('user')); // No view created yet
    }
  }
<<<<<<< HEAD


=======
>>>>>>> 32086fbf9ce339f269106a55befb686bbdc59e9e
  public function showClientsProfile()
  {
    return view('client.c_profile');
  }

<<<<<<< HEAD
  public function updateProfilePic(Request $request)
  {
    /** @var User $user */
    $user = Auth::user();

    // Validate the incoming request
    $request->validate([
      'profile_picture' => 'required|image|mimes:jpg,png,gif|max:5120', // Adjust the max size as needed
    ]);

    // Handle the uploaded file
    if ($request->hasFile('profile_picture')) {
      // Delete the old profile picture if it exists
      if ($user->profile_image && Storage::exists($user->profile_image)) {
        Storage::delete($user->profile_image);
      }

      // Get the uploaded file
      $file = $request->file('profile_picture');

      // Create a unique name for the file using the original name and the user's last name
      $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
      $lastName = $user->last_name;
      $newFileName = "{$fileName}_{$lastName}." . $file->getClientOriginalExtension();

      // Store the file and get the path
      $path = $file->storeAs('profile_pictures', $newFileName, 'public');

      // Update the user's profile picture path in the database
      $user->profile_image = $path;
      $user->save();
    }

    return redirect()->back()->with('success', 'Profile picture updated successfully.');
=======
  public function showTeamProfile()
  {
    return view('freelancer.Team_profile');
>>>>>>> 32086fbf9ce339f269106a55befb686bbdc59e9e
  }
}
