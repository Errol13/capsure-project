<?php

namespace App\Livewire;

use App\Models\Hiring\Hiring_request;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NegotiateModal extends Component
{
    public $hiringRequestId;
    public $hiringRequestData;
    public $clientPricing;
    public $service;
    public $freelancerPricing;
    public $dealerUserType;

    public function mount($hiringRequestId, $service)
    {
        $this->hiringRequestId = $hiringRequestId;
        $this->service = $service;
        $this->hiringRequestData = Hiring_request::find($hiringRequestId);
        $this->clientPricing = $this->hiringRequestData->client_pricing;
        $this->freelancerPricing = $this->hiringRequestData->freelancer_pricing;

        // Determine the dealer user type
        $this->dealerUserType = $this->getDealerUserType();
    }

    public function render()
    {
        return view('livewire.negotiate-modal');
    }

    public function updateOffer()
    {
        // Update pricing based on dealer user type
        if ($this->dealerUserType === 'client') {
            $this->hiringRequestData->client_pricing = $this->clientPricing;
            $this->hiringRequestData->dealer_user_type = 'client';
        } elseif ($this->dealerUserType === 'freelancer') {
            $this->hiringRequestData->freelancer_pricing = $this->freelancerPricing;
            $this->hiringRequestData->dealer_user_type = 'freelancer';
        }

        $this->hiringRequestData->save();

        $this->dispatch('offerUpdated');
    }

    private function getDealerUserType()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Determine user type based on the `user_type` field
        return $user ? $user->user_type : null;
    }
}
