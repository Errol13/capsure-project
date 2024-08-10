<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

   /* protected function create(array $data)
    {
        // Default user creation method
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => 'default', 
        ]);
    }*/

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
    protected function registerClient(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->createClient($request->all());

        $this->guard()->login($user);

        return redirect($this->redirectPath());
    }

    // Handle freelancer registration
    protected function registerFreelancer(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->createFreelancer($request->all());

        $this->guard()->login($user);

        return redirect($this->redirectPath());
    }

    // Create client
    protected function createClient(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => 'client', 
        ]);
    }

    // Create freelancer
    protected function createFreelancer(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => 'freelancer', 
        ]);
    }
}
