<?php

namespace App\Livewire;

use App\Models\Profile\Portfolio;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Addportfolio extends Component
{
    use WithFileUploads;

    public $album_name;
    public $files = [];
    public $freelancer_id;
    public $titleExists = false;

    protected $messages = [
        'files.required' => 'Upload at least 1 file.',
        'files.*.max' => 'The file may not be greater than 50MB.',
    ]; 

    public function mount()
    {
        $this->files = [];
    }

    public function updatedFiles()
    {
        // Append new files to the existing ones without duplicating
        $newFiles = $this->files;
        $this->files = array_unique(array_merge($this->files, $newFiles), SORT_REGULAR);
    }

    public function removeFile($index)
    {
        if (isset($this->files[$index])) {
            unset($this->files[$index]);
            $this->files = array_values($this->files); // Reindex the array
        }
    }

    public function updatedAlbumName()
    {
        $this->titleExists = Portfolio::where('freelancer_id', $this->freelancer_id)
            ->where('album_name', $this->album_name)
            ->exists();

        if ($this->titleExists) {
            $this->addError('album_name', 'This album title already exists!');
        } else {
            $this->resetErrorBag('album_name');
        }
    }

    public function save()
    {
        $this->validate([
            'album_name' => 'required|string|max:255',
            'files' => 'required|array|min:1|max:10', // Ensure at least one file and no more than 5
            'files.*' => 'mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:51200', // Validate file types and size (max 50MB per file)
        ]);

        if ($this->titleExists) {
            $this->addError('album_name', 'This album title already exists!');
            return;
        }

        // Create a new portfolio
        $portfolio = new Portfolio();
        $portfolio->freelancer_id = $this->freelancer_id;
        $portfolio->album_name = $this->album_name;
        $portfolio->save();

        // Handle file uploads
        $paths = [];
        foreach ($this->files as $file) {
            // Generate a unique file name to avoid overwriting
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/portfolios/' . $portfolio->portfolio_id, $fileName);
            $paths[] = $path;
        }

        // Update portfolio with file paths
        $portfolio->path = json_encode($paths);
        $portfolio->save();

        session()->flash('success', 'Portfolio created successfully.');

        // Reset form after save
        $this->reset();


        return redirect()->route('freelancer-settings');
    }

    public function resetForm()
    {
        $this->album_name = "";
        $this->files = [];
    }

    public function render()
    {
        return view('livewire.addportfolio');
    }
}
