<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Freelancer;
use App\Models\Profile\Service as ProfileService;
use App\Models\Profile\SocialMediaAccount as ProfileSocialMediaAccount;
use App\Models\Service;
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
        return view('auth.signup_freelancer');
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
        $this->validator($request->all())->validate();

        $user = $this->createFreelancer($request->all());

        // Create the associated service record for the freelancer
        $this->createService($user->id, $request->all());

        // Trigger the email verification event
        event(new Registered($user));

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

        // Define the platforms
        $platforms = ['Facebook', 'LinkedIn', 'Instagram'];

        foreach ($platforms as $platform) {
            ProfileSocialMediaAccount::create([
                'user_id' => $user->id,
                'platform' => $platform,
                'url' => '', // Initialize with empty URL
            ]);
        }

        Freelancer::create([
            'user_id' => $user->id,

        ]);

        return $user;
    }

    // Create service record for freelancer
    protected function createService(int $userId, array $data)
    {
        ProfileService::create([
            'user_id' => $userId,
            'job_category' => $data['job_category'],
            'job_title' => $data['job_title'],
            'fee_type' => $data['fee_type'],
            'job_fee' => $data['job_fee'],
        ]);
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
