<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Freelancer;
use App\Models\Profile\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        // Check if the album name already exists for this freelancer
        if (Portfolio::where('freelancer_id', $id)->where('album_name', $request->input('album_name'))->exists()) {
            return redirect()->back()->withErrors(['album_name' => 'The album name already exists!']);
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

        return redirect()->back()->with('success', 'Portfolio created successfully.');
    }

    public function deleteAlbum(Request $request)
    {
        $request->validate([
            'album_id' => 'required|exists:portfolios,portfolio_id',
        ]);

        $portfolio = Portfolio::findOrFail($request->input('album_id'));

        // Delete associated files
        $filePaths = json_decode($portfolio->path);
        foreach ($filePaths as $filePath) {
            Storage::delete($filePath);
        }

        // Delete the portfolio record
        $portfolio->delete();

        // Delete the directory if empty
        $directory = 'public/portfolios/' . $portfolio->portfolio_id;
        if (Storage::exists($directory) && count(Storage::files($directory)) === 0) {
            Storage::deleteDirectory($directory);
        }

        return redirect()->back()->with('success', 'Album deleted successfully.');
    }




    public function deleteImage(Request $request)
    {
        $filePath = $request->input('filePath');
        $portfolioId = $this->extractPortfolioId($filePath); // Implement this method to extract portfolio ID from the path

        // Find the portfolio and its images
        $portfolio = Portfolio::find($portfolioId);
        if (!$portfolio) {
            return response()->json(['success' => false, 'message' => 'Portfolio not found.']);
        }

        $paths = json_decode($portfolio->path, true);

        // Check if deleting this image will empty the portfolio
        if (count($paths) === 1 && $paths[0] === $filePath) {
            // Delete the portfolio record if it's the last image
            $portfolio->delete();
        } else {
            // Remove the image path from the portfolio
            $paths = array_filter($paths, fn($path) => $path !== $filePath);
            $portfolio->path = json_encode($paths);
            $portfolio->save();
        }

        // Delete the actual file from storage
        if (Storage::exists('public/' . $filePath)) {
            Storage::delete('public/' . $filePath);
        }

        return response()->json(['success' => true]);
    }




    public function addToAlbum()
    {
        //
    }
}
