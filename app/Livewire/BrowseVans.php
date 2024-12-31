<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Van;

class BrowseVans extends Component
{
    public $selectedVan = null;
    public $showBookingForm = false;

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

    public function render()
    {
        $vans = Van::all();
        return view('livewire.browse-vans', ['vans' => $vans]);
    }
}
