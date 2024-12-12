<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Freelancer;
use App\Models\Profile\Service;
use App\Models\Profile\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->user_type == 'client') {
                // Load client-specific content
                $users = User::where('user_type', 'freelancer')
                    ->with(['freelancer.services', 'freelancer.portfolios'])
                    ->orderBy('id')
                    ->paginate(9);
                //get the team freelancers
                $teams = Team::whereHas('memberships', function ($query) {
                    $query->where('status', 'active');
                }, '>=', 4) // Ensure at least 4 active memberships
                    ->orderBy('avg_rating') // Ascending order by average rating
                    ->orderByDesc('created_at') // Descending order by creation date
                    ->paginate(4);

                return view('client.c_home', compact('users', 'teams'));
            } elseif ($user->user_type == 'freelancer') {
                return view('freelancer.f_home');
            } elseif ($user->user_type == 'admin') {
                // Load admin-specific content
                return redirect()->route('filament.admin.pages.dashboard');
            }
        } else {
            // Load general content for guests

            $freelancers = Freelancer::with('user')->orderBy('avg_rating', 'desc')
                ->orderBy('number_of_projects', 'desc')
                ->take(8)
                ->get();

            return view('welcome', compact('freelancers'));
        }
    }

    public function freelancerToClient()
    {
        $user = auth()->user();

        //check if there is an existing client data
        if ($user->client) {
            //then switch the user_type to client
            $user->user_type = 'client';
            $user->save();

            return redirect()->route('client-homepage'); //redirect to homepage of client
        } else {
            //create a new client data
            $client = new Client([
                'user_id' => $user->id,
            ]);

            //save the data
            $client->save();

            //now, we will change the user_type to client
            $user->user_type = 'client';
            $user->save();

            return redirect()->route('client-homepage'); //redirect to homepage of client
        }
    }

    public function clientToFreelancer()
    {
        $user = auth()->user();

        //check if there is an existing freelancer data
        if ($user->freelancer !== null) {
            //then switch the user_type to freelancer
            $user->user_type = 'freelancer';
            $user->save();

            return redirect()->route('freelancer-homepage'); //redirect to homepage of freelancer
        } else {
            return redirect()->route('be-freelancer'); //redirect to a form
        }
    }

    public function becomeFreelancer(Request $request)
    {

        //get the auth user
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            'job_category' => 'required|string',
            'job_title' => 'required|string',
            'custom_job_title' => 'nullable|string|max:255',
            'job_fee' => 'required|numeric|min:20',
            'fee_type' => 'required|string|in:/hour,/project',
        ]);

        //if fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        //now create a freelancer data
        Freelancer::create([
            'user_id' => $user->id,
        ]);

        // Determine job title
        $jobTitle = !empty($validated['custom_job_title']) ? $validated['custom_job_title'] : $validated['job_title'];

        //create and store service
        Service::create([
            'freelancer_id' => $user->id,
            'job_category' => $validated['job_category'],
            'job_title' => $jobTitle, // Use custom job title if provided
            'fee_type' => $validated['fee_type'],
            'job_fee' => $validated['job_fee'],
        ]);

        //change the user type
        $user->user_type = 'freelancer';
        $user->save();

        return redirect()->route('freelancer-homepage'); //redirect to a freelancer homepage

    }
}
