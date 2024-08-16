<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Freelancer;
use App\Models\Profile\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    //show settings page

    public function showFreelancerSettings()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->user_type == 'freelancer') {
            // Load related data for freelancers
            $user->load('freelancer.services', 'freelancer.certificates', 'freelancer.portfolios');
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
            'availability' => 'required|string',
        ]);

        // Find the service by ID
        $service = Service::findOrFail($serviceId);

        $user = $request->user();

        // Ensure the service belongs to the current freelancer
        if ($service->freelancer_id !== $user->freelancer->id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Update the service with the validated data
        $service->update($validatedData);

        return redirect()->back()->with('success', 'Service updated successfully.');
    }
}
