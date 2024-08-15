<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
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
            'email' => 'required|email|unique:users,email,' . $id,
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

        // Hash the password if provided
        if (isset($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        // Update the user's information with validated data
        $user->update($updateData);

        // Redirect or return response
        return redirect()->route('freelancer-settings')
            ->with('success', 'Profile updated successfully.');
    }
}
