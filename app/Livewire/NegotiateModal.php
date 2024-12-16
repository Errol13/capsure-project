<?php

namespace App\Livewire;

use App\Models\Hiring\Hiring_request;
use App\Models\Profile\Team;
use App\Models\User;
use App\Notifications\NewOffer;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NegotiateModal extends Component
{
    public $hiringRequestId;
    public $hiringRequestData;
    public $clientPricing;
    public $service;
    public $freelancerPricing;
    public $dealerUserType;
    public $isLower = false;
    public $isTeam = false; // for team

    public function mount($hiringRequestId, $service)
    {
        $this->hiringRequestId = $hiringRequestId;
        $this->service = $service;
        $this->hiringRequestData = Hiring_request::find($hiringRequestId);
        $this->clientPricing = $this->hiringRequestData->client_pricing;
        $this->freelancerPricing = $this->hiringRequestData->freelancer_pricing;

        //for team
        if ($this->hiringRequestData->team_code !== null) {
            $this->isTeam = true;
        }

        // Determine the dealer user type
        $this->dealerUserType = $this->getDealerUserType();
    }

    public function render()
    {
        return view('livewire.negotiate-modal');
    }

    //show the warning if the freelancer offers lower offer compared to current client offer
    public function warningLowerOffer($freelancerPricing)
    {
        // Clean the input and check if the offer is lower
        $this->freelancerPricing = preg_replace('/[^0-9.]/', '', $freelancerPricing);

        if ($this->freelancerPricing < $this->clientPricing) {
            $this->isLower = true;
        } else {
            $this->isLower = false;
        }

        $this->dispatch('showWarning', isLower: $this->isLower);
    }

    public function updateOffer()
    {
        // Clean up the input values by removing non-numeric characters
        $this->clientPricing = preg_replace('/[^0-9.]/', '', $this->clientPricing);
        $this->freelancerPricing = preg_replace('/[^0-9.]/', '', $this->freelancerPricing);

        //find the one who will be notified, by default empty
        $dealee = null;
        $team = null;
        // Update pricing based on dealer user type
        if ($this->dealerUserType === 'client' && $this->isTeam === false) {
            $this->hiringRequestData->client_pricing = $this->clientPricing;
            $this->hiringRequestData->dealer_user_type = 'client';
            $dealee = User::find($this->hiringRequestData->freelancer_id);
        } elseif ($this->dealerUserType === 'client' && $this->isTeam) { //client negotiating with team leader
            $this->hiringRequestData->client_pricing = $this->clientPricing;
            $this->hiringRequestData->dealer_user_type = 'client';
            $team = Team::where('team_code', $this->hiringRequestData->team_code)->first();
            $dealee = User::find($team->team_leader);
        } elseif ($this->dealerUserType === 'freelancer' && $this->isTeam !== true) {
            $this->hiringRequestData->freelancer_pricing = $this->freelancerPricing;
            $this->hiringRequestData->dealer_user_type = 'freelancer';
            $dealee = User::find($this->hiringRequestData->client_id);
        } elseif ($this->dealerUserType === 'freelancer' && $this->isTeam) {
            $this->hiringRequestData->freelancer_pricing = $this->freelancerPricing;
            $this->hiringRequestData->dealer_user_type = 'freelancer';
            $team = Team::where('team_code', $this->hiringRequestData->team_code)->first();
            $dealee = User::find($this->hiringRequestData->client_id);
        }

        $this->hiringRequestData->save();

        //determine the name of the one who made the deal
        $dealerName = null;
        if ($this->dealerUserType === 'client') {
            $dealer =  auth()->user();
            $dealerName = "{$dealer->first_name} {$dealer->last_name}";
        } elseif ($this->dealerUserType === 'freelancer' && $this->isTeam) {
            $dealerName = "{$team->team_name}";
        } elseif ($this->dealerUserType === 'freelancer' && $this->isTeam !== true) {
            $dealer =  auth()->user();
            $dealerName = "{$dealer->first_name} {$dealer->last_name}";
        }

        $dealee->notify(new NewOffer(
            $dealerName,
            $this->hiringRequestData->eventjob->event->title,
            $this->hiringRequestData->eventjob->event->event_id
        ));

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
