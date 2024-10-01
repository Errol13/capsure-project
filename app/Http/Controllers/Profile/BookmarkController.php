<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Freelancer;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function showBookMark()
    {
        // Get the client instance (assuming the user is authenticated)
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

    
}
