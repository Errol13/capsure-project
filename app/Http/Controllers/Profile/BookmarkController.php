<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function showBookMark()
    {
        return view('client.c_bookmarks');
    }

    //save the freelancer
    public function bookmarkFreelancers($freelancer_id){
        
    }
}
