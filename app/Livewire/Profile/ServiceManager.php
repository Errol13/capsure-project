<?php

namespace App\Livewire\Profile;

use Livewire\Attributes\On;
use Livewire\Component;

class ServiceManager extends Component
{

    public $editingServiceId = null;
    public $serviceData = [];
    public $services;
    public $showMessage = false;

    public function mount($services)
    {
        $this->services = $services;

        $this->serviceData = $services->mapWithKeys(function ($service) {
            return [
                $service->id => [
                    'title' => $service->job_title,
                    'fee' => $service->job_fee,
                    'fee_type' => $service->fee_type,
                    'isAvailable' => $service->isAvailable,
                ],
            ];
        })->toArray();
    }

    public function editService($id)
    {
        $this->editingServiceId = $id;
    }

    public function saveService()
    {
        if ($this->editingServiceId && isset($this->serviceData[$this->editingServiceId])) {
            // Fetch the service from the database
            $service = $this->services->find($this->editingServiceId);

            // Check if service exists
            if ($service) {
                // Update service attributes
                $service->update([
                    'job_title' => $this->serviceData[$this->editingServiceId]['title'],
                    'job_fee' => $this->serviceData[$this->editingServiceId]['fee'],
                    'fee_type' => $this->serviceData[$this->editingServiceId]['fee_type'],
                    'isAvailable' => $this->serviceData[$this->editingServiceId]['isAvailable'],
                ]);

                $this->showMessage = true; // Show the message

                $this->dispatch('hide-message', false); // Pass false to hide the message

                session()->flash('message', 'Service updated successfully.');

                $this->resetFields();
                $this->editingServiceId = null;
            }
        }
    }

    #[On('hide-message')]
    //close the message 
    public function setShowMessage($value)
    {
        $this->showMessage = $value;
    }

    public function toggleAvailability($id)
    {
        // Find the service in the database
        $service = $this->services->find($id);

        // If the service exists, toggle the availability
        if ($service) {
            // update the availability status in the db
            $service->isAvailable = !$service->isAvailable;
            $service->save();

            // Updates the local state
            $this->serviceData[$id]['isAvailable'] = $service->isAvailable;
        }
    }


    public function resetFields()
    {
        $this->editingServiceId = null;
        // Only reset the specific service data entry if editingServiceId is set
        if ($this->editingServiceId !== null && isset($this->serviceData[$this->editingServiceId])) {
            unset($this->serviceData[$this->editingServiceId]);
        }
    }


    public function render()
    {
        return view('livewire.profile.service-manager');
    }
}
