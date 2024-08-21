<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Freelancer;
use App\Models\Profile\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class SettingsController extends Controller
{
    //show settings page

    public function showFreelancerSettings()
    {
        /** @var User $user */
        $user = Auth::user();

        $socmed = $user->socmed()->orderBy('id', 'asc')->get();

        if ($user->user_type == 'freelancer') {
            // Load related data for freelancers with ordering
            $user->load([
                'freelancer.services' => function ($query) {
                    $query->orderBy('id', 'asc');
                },
                'freelancer.certificates' => function ($query) {
                    $query->orderBy('cert_id', 'asc');
                },
                'freelancer.portfolios' => function ($query) {
                    $query->orderBy('portfolio_id', 'asc');
                }
            ]);

            return view('freelancer.f_setting', compact('user'));
        }
    }

    public function updateFreelancer(Request $request, $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'street' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'contact_number' => 'nullable|numeric|digits:11',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Prepare data for update
        $updateData = $validated;

        //Update the age when birthdate is changed
        $updateData['age'] = \Carbon\Carbon::parse($validated['birthdate'])->age;

        // Hash the password only if provided
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        } else {
            // Remove the password from the update data if it’s null or empty
            unset($updateData['password']);
        }

        // Update the user's information with validated data
        $user->update($updateData);

        // Redirect 
        return redirect()->route('freelancer-settings')
            ->with('success', 'Profile updated successfully.');
    }



    public function updateServices(Request $request, $serviceId)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'job_title' => 'required|string',
            'job_fee' => 'required|numeric',
            'fee_type' => 'required|string',
            'job_category' => 'required|string',
            'availability' => 'required|string|in:available,not_available',
        ]);



        // Find the service by ID
        $service = Service::findOrFail($serviceId);

        // Convert availability to boolean for isAvailable
        $isAvailable = strtolower($request->availability) === 'available';

        // Update the service attributes
        $service->job_title = $validatedData['job_title'];
        $service->job_fee = $validatedData['job_fee'];
        $service->fee_type = $validatedData['fee_type'];
        $service->job_category = $validatedData['job_category'];
        $service->isAvailable = $isAvailable;


        // Save the updated service
        $service->save();


        // Redirect to the freelancer settings page
        return redirect()->route('freelancer-settings');
    }

    public function updateTerms(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'terms_and_conditions' => 'required|string|max:500',
        ]);

        //find the freelancer
        $freelancer = Freelancer::findOrfail($id);

        $freelancer->terms_and_conditions = $validatedData['terms_and_conditions'];

        $freelancer->save();

        return redirect()->back();
    }
}
