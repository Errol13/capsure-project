<?php

namespace App\Livewire;

use App\Models\Profile\Portfolio;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class UpdatePortfolio extends Component
{
    use WithFileUploads;

    public $portfolios;
    public $selectedAlbumId;
    public $files = [];

    protected $rules = [
        'selectedAlbumId' => 'required|exists:portfolios,portfolio_id',
        'files.*' => 'file|mimes:jpg,png,gif,mp4|max:51200' // Maximum size 50MB
    ];

    public function mount($portfolios)
    {
        $this->portfolios = $portfolios;
    }

    public function updatedFiles()
    {
        $this->dispatch('fileUploaded');
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
            $path = $file->store('public/portfolios');
            $portfolio->path = json_encode(array_merge(json_decode($portfolio->path, true) ?? [], [$path]));
        }

        $portfolio->save();

        session()->flash('success', 'Album updated successfully.');

        $this->reset();
    }

    public function resetForm()
    {
        $this->selectedAlbumId= "";
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
