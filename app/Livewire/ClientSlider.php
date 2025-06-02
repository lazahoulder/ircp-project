<?php

namespace App\Livewire;

use App\Services\EntiteEmmeteursService;
use Livewire\Component;

class ClientSlider extends Component
{
    protected EntiteEmmeteursService $service;

    public function boot(EntiteEmmeteursService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        // Get the first 5 clients
        $paginator = $this->service->search();
        $clients = $paginator->items();

        // Limit to 5 items
        if (count($clients) > 5) {
            $clients = array_slice($clients, 0, 5);
        }

        return view('livewire.client-slider', [
            'clients' => $clients
        ]);
    }
}
