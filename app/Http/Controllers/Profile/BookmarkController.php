<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Freelancer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function showBookMark()
    {
        // Get the client instance 
        $client = Client::find(auth()->id());
    
        // Decode the favorites JSON into an array
        $favorites = $client->favorites ? json_decode($client->favorites, true) : [];
    
        // Retrieve the freelancers using the favorite IDs
        $freelancers = Freelancer::with(['portfolios', 'user', 'services'])->whereIn('user_id', $favorites)->get();
    
        // Pass the freelancers collection to the view
        return view('client.c_bookmarks', compact('freelancers'));
    }
    

    //save the freelancer
    public function addFavorite($freelancerId)
    {
        $client = auth()->user()->client; 
        $client->addFavorite($freelancerId);

        return response()->json(['success' => true]);
    }

    public function removeFavorite($freelancerId)
    {
        $client = auth()->user()->client;
        $client->removeFavorite($freelancerId);

        return redirect()->back()->with('success', 'Successfully removed a favorite.');
    }

    //I'll put here the show All notifs
    public function showAllNotifications(){

        //get the notifications
        $user = auth()->user();
        $notifications = $user->notifications()->paginate(10);
        return view('components.Profile.all_notifications', compact('notifications'));
    }

    //mark all as read
    public function markAllasRead(){
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'Mark as read successfully!');
    }

    
}
