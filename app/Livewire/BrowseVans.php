<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Van;

class BrowseVans extends Component
{
    use WithFileUploads;
    public $selectedVan = null;
    public $showBookingForm = false;
    public $termsAccepted = false;
    public $name;
    public $startDate;
    public $endDate;
    public $license;

    public function toggleTermsAccepted()
    {
        $this->termsAccepted = !$this->termsAccepted;
    }

    public function selectVan($vanId)
    {
        $this->selectedVan = Van::find($vanId);

        if (!auth()->check()) {
            // Emit event to trigger registration popup for unregistered users
            $this->emit('showRegisterPopup');
        } else {
            // Show booking form in popup
            $this->showBookingForm = true;
        }
    }

    public function closeBookingForm()
    {
        $this->showBookingForm = false;
        $this->selectedVan = null;
    }
    public function bookVan()
    {
        dd($this->termsAccepted);
        $this->validate([
            'name' => 'required|string|max:255',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after_or_equal:startDate',
            'license' => 'required|mimes:pdf|max:2048', // PDF, max 2MB
        ]);

        if (!$this->termsAccepted) {
            session()->flash('error', 'You must agree to the terms and conditions before proceeding.');
            return;
        }

        $licensePath = $this->license->store('licenses', 'public');

        // Add booking logic here
        session()->flash('success', 'Van successfully booked!');

        $this->reset(['name', 'startDate', 'endDate', 'license', 'termsAccepted']);
        $this->closeBookingForm();
    }
    public function render()
    {
        // dd($this->termsAccepted);
        $vans = Van::all();
        return view('livewire.browse-vans', ['vans' => $vans]);
    }
}
