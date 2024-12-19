<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Profile\SocialMediaAccount as ProfileSocialMediaAccount;
use App\Models\SocialMediaAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocMedController extends Controller
{
    /*public function showSocMed()
    {

        /** @var User $user 
        $user = Auth::user();

        $socmed = $user->socmed;

        return view('components.social_media', compact('socmed'));
    } */



    public function updateSocMed(Request $request, $platform)

    {

        /** @var User $user */
        $user = Auth::user();

        // Validate the input
        $request->validate([
            'url' => 'nullable|url',
        ]);


        // Find the social media record by platform and authenticated user
        $socialMedia = ProfileSocialMediaAccount::where('platform', $platform)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Update the URL
        $socialMedia->url = $request->input('url') ?? '';
        $socialMedia->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', ucfirst($platform) . ' URL updated successfully.');
    }
}
