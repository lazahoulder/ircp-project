<?php

namespace App\Livewire;

use Livewire\Component;

class SearchBar extends Component
{
    public string $q = '';

    public function updatedQ()
    {
        // Quand la valeur change, on déclenche un événement vers le composant ListCertificate
        $this->dispatch('search-update', query: $this->q);
    }

    public function render()
    {
        return view('livewire.search-bar');
    }
}
