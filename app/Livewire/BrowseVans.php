<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Van;

class BrowseVans extends Component
{
    public $selectedVan = null;

    public function selectVan($vanId)
    {
        $this->selectedVan = Van::find($vanId);

        if (!auth()->check()) {
            // Emit event to trigger registration popup for unregistered users
            $this->emit('showRegisterPopup');
        } else {
            // Redirect to booking page
            return redirect()->route('booking', ['van' => $vanId]);
        }
    }

    public function render()
    {
        $vans = Van::all();
        return view('livewire.browse-vans', ['vans' => $vans]);
    }
}
