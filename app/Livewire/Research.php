<?php

namespace App\Livewire;

use Livewire\Component;

class Research extends Component
{
    public string $q = '';

    public function updatedQ()
    {
        logger('SearchBar updatedQ: ' . $this->q);
        $this->dispatch('search-update', query: $this->q);
    }

    public function render()
    {
        return view('livewire.recherche.research');
    }
}
