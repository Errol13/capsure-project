<?php

namespace App\Livewire;

use App\Models\Profile\Portfolio;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class UpdatePortfolio extends Component
{
    use WithFileUploads;

    public $portfolios;
    public $selectedAlbumId;
    public $files = [];
    public $newFiles = [];

    protected $rules = [
        'selectedAlbumId' => 'required|exists:portfolios,portfolio_id',
        'files.*' => 'required|file|mimes:jpg,png,gif,mp4|max:51200' // Maximum size 50MB
    ];

    public function mount($portfolios)
    {
        // Log::info('Component mounted.');
        $this->portfolios = $portfolios;
    }

    #[On('filesUpdated')]
    public function updatedNewFiles()
    {
        $this->files = array_unique(array_merge($this->files, $this->newFiles));
        $this->newFiles = []; // this will clear the holder
    }

    public function updatePortfolio()
    {
        $this->validate();

        $portfolio = Portfolio::find($this->selectedAlbumId);

        if (!$portfolio) {
            session()->flash('error', 'Selected album does not exist.');
            return;
        }

        // Handle file uploads
        foreach ($this->files as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/portfolios/' . $portfolio->portfolio_id, $fileName);

            // Log the file path
            Log::info('File stored successfully.', [
                'portfolio_id' => $portfolio->portfolio_id,
                'file_name' => $fileName,
                'file_path' => $path,
            ]);
            
            $portfolio->path = json_encode(array_merge(json_decode($portfolio->path, true) ?? [], [$path]));
        }

        $portfolio->save();

        session()->flash('success', 'Album updated successfully.');

        $this->reset();

        return redirect()->route('freelancer-settings');
    }

    public function resetForm()
    {
        $this->selectedAlbumId = "";
        $this->files = [];
    }

    public function removeFile($index)
    {
        unset($this->files[$index]);
        $this->files = array_values($this->files);
    }

    public function render()
    {

        return view('livewire.updateportfolio');
    }
}
