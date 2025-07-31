<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Profile\Certificates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    /**
     * Store a newly created certificate in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        /** @var User $user */
        $user = Auth::user();

        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create a new certificate entry without the image first
        $certificate = Certificates::create([
            'freelancer_id' => $user->id,
            'title' => $request->input('title'),
            'date' => $request->input('date'),
            'image' => '', // Placeholder for image path
        ]);

        // Store the image file with a custom name and update the certificate
        $file = $request->file('image');
        $fileName = $file->getClientOriginalName();
        $path = $file->storeAs('certificates/' . $certificate->cert_id, $fileName);

        // Update the certificate with the actual image path
        $certificate->image = $path;
        $certificate->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Award added successfully!');
    }

    /**
     * Update the specified certificate in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'cert_id' => 'required|exists:certificates,cert_id',
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the certificate to update
        $certificate = Certificates::findOrFail($request->input('cert_id'));

        // Update the certificate details
        $certificate->title = $request->input('title');
        $certificate->date = $request->input('date');

        // Update the image if a new one is uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            $oldImagePath = $certificate->image;

            // Remove the "public/" prefix for the old image path
            if (Str::startsWith($oldImagePath, 'public/')) {
                $oldImagePath = str_replace('public/', '', $oldImagePath);
            }

            // Delete the old image
            if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }

            // Store the new image with a custom name
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'certificates/' . $certificate->cert_id;
            $path = $file->storeAs('public/' . $filePath, $fileName);

            // Update the certificate with the new image path (relative to public disk root)
            $certificate->image = str_replace('public/', '', $path);
        }

        // Save the updated certificate
        $certificate->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Award updated successfully!');
    }


    /**
     * Remove the specified certificate from storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        // Validate the request data
        $request->validate([
            'cert_id' => 'required|exists:certificates,cert_id',
        ]);

        // Find the certificate to delete
        $certificate = Certificates::findOrFail($request->input('cert_id'));

        // Construct the file path (if needed)
        $filePath = str_replace('public/', '', $certificate->image);

        // Delete the image file if it exists
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        // Delete the certificate record
        $certificate->delete();

        // Remove empty directories
        $this->removeEmptyDirectories(dirname($filePath));

        // Redirect back with success message
        return redirect()->back()->with('success', 'Award deleted successfully!');
    }

    public function removeEmptyDirectories($path)
    {
        // Remove empty directories recursively
        $directory = storage_path('app/public/' . $path);

        // Check if the directory exists
        if (is_dir($directory)) {
            $files = array_diff(scandir($directory), ['.', '..']);
            if (empty($files)) {
                // If the directory is empty, delete it
                rmdir($directory);

                // Continue removing parent directories
                $parentPath = dirname($path);
                if ($parentPath !== $path) {
                    $this->removeEmptyDirectories($parentPath);
                }
            }
        }
    }
}
