<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Freelancer;
use App\Models\Profile\Service as ProfileService;
use App\Models\Profile\SocialMediaAccount as ProfileSocialMediaAccount;
use App\Models\SocialMediaAccount;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'contact_number' => ['nullable', 'numeric', 'digits:11'],
        ]);
    }

    // Show client registration form
    public function showClientRegisterForm()
    {
        return view('auth.signup_client');
    }

    // Show freelancer registration form
    public function showFreelancerRegisterForm()
    {
        //Define default job titles for each category
        $defaultJobTitles = [
            'Arts' => ['Painter', 'Sculptor', 'Illustrator'],
            'Entertainment' => ['Actor', 'Musician', 'Dancer', 'Choreographer', 'Comedian', 'Clown Artist'],
            'Event Planner' => ['Wedding Coordinator', 'Corporate Event Planner'],
            'Food Service' => ['Chef', 'Food Caterer'],
            'Handicrafts' => ['Craft Maker', 'Jewelry Designer', 'Beader'],
            'Online Services' => ['Virtual Assistant', 'SEO Specialist', 'Tutor'],
            'Photography' => ['Photographer', 'Photo Editor'],
            'Styling' => ['Fashion Stylist', 'Makeup Artist'],
            'Videography' => ['Event Videographer', 'Corporate Videographer', 'Videographer'],
            'Voice Talent' => ['Narrator', 'Singer', 'Host', 'Voice Actor'],
            'Package' => ['Wedding Package', 'Birthday Package'],
        ];

        //Fetch existing job titles from the database
        $existingJobTitles = ProfileService::select('job_category', 'job_title')
            ->groupBy('job_category', 'job_title')
            ->get()
            ->groupBy('job_category')
            ->toArray();

        // Merge default and existing job titles (no duplicates)
        $jobTitles = [];
        foreach ($defaultJobTitles as $category => $titles) {
            // Existing titles for this category
            $existingTitles = isset($existingJobTitles[$category])
                ? array_column($existingJobTitles[$category], 'job_title')
                : [];

            // Merge default and existing titles, remove duplicates
            $jobTitles[$category] = array_unique(array_merge($titles, $existingTitles));
        }

        //Send the combined list to the view
        return view('auth.signup_freelancer', compact('jobTitles'));
    }


    // Handle client registration
    public function registerClient(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->createClient($request->all());

        // Trigger the email verification event
        event(new Registered($user));

        $this->guard()->login($user);

        return redirect($this->redirectPath());
    }

    // Handle freelancer registration
    public function registerFreelancer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'job_category' => 'required|string',
            'job_title' => 'required|string',
            'custom_job_title' => 'nullable|string|max:255',
            'job_fee' => 'required|numeric|min:20',
            'fee_type' => 'required|string|in:/hour,/project',
            'birth_month' => 'required|integer|between:1,12',
            'birth_day' => 'required|integer|between:1,31',
            'birth_year' => 'required|integer|between:' . (date('Y') - 100) . ',' . date('Y'),
            'street' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Creating freelancer and associated service in one go
        $user = $this->createFreelancer($request->all());

        // Trigger the email verification event
        event(new Registered($user));

        // Log the user in
        $this->guard()->login($user);

        return redirect($this->redirectPath());
    }


    // Create client
    protected function createClient(array $data)
    {
        $birthdate = "{$data['birth_year']}-{$data['birth_month']}-{$data['birth_day']}";
        $age = \Carbon\Carbon::parse($birthdate)->age;

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => 'client',
            'date_joined' => now(),
            'birthdate' => $birthdate,
            'age' => $age,
            'street' => $data['street'] ?? null,
            'barangay' => $data['barangay'] ?? null,
            'city' => $data['city'] ?? null,
            'contact_number' => $data['contact_number'] ?? null,
        ]);

        // Define the platforms
        $platforms = ['Facebook', 'LinkedIn', 'Instagram'];

        foreach ($platforms as $platform) {
            ProfileSocialMediaAccount::create([
                'user_id' => $user->id,
                'platform' => $platform,
                'url' => '', // Initialize with empty URL
            ]);
        }

        Client::create([
            'user_id' => $user->id,
        ]);

        return $user;
    }

    // Create freelancer
    protected function createFreelancer(array $data)
    {
        $birthdate = "{$data['birth_year']}-{$data['birth_month']}-{$data['birth_day']}";
        $age = \Carbon\Carbon::parse($birthdate)->age;

        // Create user record
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => 'freelancer',
            'date_joined' => now(),
            'birthdate' => $birthdate,
            'age' => $age,
            'street' => $data['street'] ?? null,
            'barangay' => $data['barangay'] ?? null,
            'city' => $data['city'] ?? null,
            'contact_number' => $data['contact_number'] ?? null,
        ]);

        // Initialize default social media accounts
        $platforms = ['Facebook', 'LinkedIn', 'Instagram'];
        foreach ($platforms as $platform) {
            ProfileSocialMediaAccount::create([
                'user_id' => $user->id,
                'platform' => $platform,
                'url' => '', // Initialize with empty URL
            ]);
        }

        // Create freelancer-specific data
        Freelancer::create([
            'user_id' => $user->id,
        ]);

        // Determine job title
        $jobTitle = !empty($data['custom_job_title']) ? $data['custom_job_title'] : $data['job_title'];

        // Create associated service
        ProfileService::create([
            'freelancer_id' => $user->id,
            'job_category' => $data['job_category'],
            'job_title' => $jobTitle, // Use custom job title if provided
            'fee_type' => $data['fee_type'],
            'job_fee' => $data['job_fee'],
        ]);

        return $user;
    }


    protected function redirectTo()
    {
        $user = Auth::user();

        if ($user->user_type === 'client') {
            return '/client-homepage';
        } elseif ($user->user_type === 'freelancer') {
            return '/freelancer-homepage';
        }

        return '/home'; // Default redirect 
    }
}
