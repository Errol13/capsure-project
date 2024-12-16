<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Freelancer;
use App\Models\Profile\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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




    public function deleteFiles(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'portfolios' => 'required|array',
        'portfolios.*' => 'required|array',
        'portfolios.*.*' => 'required|string', // Each file path within each portfolio
    ]);

    Log::info('Delete Files requests:', $request->all());

    $deletedFiles = [];
    $failedFiles = [];

    foreach ($request->portfolios as $portfolioId => $files) {
        // Find the portfolio
        $portfolio = Portfolio::find($portfolioId);
        if (!$portfolio) {
            $failedFiles[] = "Portfolio ID {$portfolioId} not found.";
            continue;
        }

        // Get existing paths from the portfolio (including 'public/' prefix)
        $paths = json_decode($portfolio->path, true) ?: [];

        foreach ($files as $filePath) {
            // Prepend 'public/' to the relative path for comparison
            $relativePath = 'public/portfolios/' . $portfolioId . '/' . basename($filePath);
            Log::info("Checking file path: {$relativePath} against stored paths: ", $paths);

            // Check if the file exists in the current portfolio paths
            if (in_array($relativePath, $paths)) {
                // Remove the file path from the paths array
                $paths = array_filter($paths, fn($path) => $path !== $relativePath);

                // Delete the file from storage
                if (Storage::exists($relativePath)) { // Ensure correct path for deletion
                    if (Storage::delete($relativePath)) {
                        $deletedFiles[] = $relativePath;
                    } else {
                        $failedFiles[] = "Failed to delete file: {$relativePath}.";
                    }
                } else {
                    $failedFiles[] = "File not found in storage: {$relativePath}.";
                }
            } else {
                Log::warning("File path mismatch or not found in portfolio: {$relativePath}.");
                $failedFiles[] = "File path mismatch or not found in portfolio: {$relativePath}.";
            }
        }

        // Update the portfolio or delete it if empty
        if (empty($paths)) {
            // Delete the portfolio if there are no remaining images
            $portfolio->delete();
        } else {
            // Update the portfolio with the remaining paths
            $portfolio->path = json_encode(array_values($paths));
            $portfolio->save();
        }
    }

    if (empty($failedFiles)) {
        return response()->json(['success' => true, 'deleted' => $deletedFiles]);
    } else {
        return response()->json(['success' => false, 'message' => 'Some files could not be deleted.', 'failed' => $failedFiles]);
    }
}




    public function addToAlbum()
    {
        //
    }
}
