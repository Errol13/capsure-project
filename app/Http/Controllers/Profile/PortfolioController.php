<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Freelancer;
use App\Models\Profile\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    //


    public function addPortfolio(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'album_name' => 'required|string|max:255',
            'files.*' => 'mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:20480', // Validates file types and size
        ]);

        // Check if files are provided
        if (!$request->hasFile('files')) {
            return redirect()->back()->withErrors(['files' => 'Please upload files.']);
        }

        // Create a new portfolio
        $portfolio = new Portfolio();
        $portfolio->freelancer_id = $id;
        $portfolio->album_name = $request->input('album_name');
        $portfolio->save();

        // Handle file uploads
        $paths = [];
        foreach ($request->file('files') as $file) {
            // Generate a unique file name to avoid overwriting
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/portfolios/' . $portfolio->portfolio_id, $fileName);
            $paths[] = $path;
        }

        // Update portfolio with file paths
        $portfolio->path = json_encode($paths);
        $portfolio->save();

        return redirect()->back();
    }


    public function showPortfolios()
    {
        //
    }
}
