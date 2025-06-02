<?php

namespace App\Livewire;

use App\Services\EntiteEmmeteursService;
use Livewire\Component;
use Livewire\WithPagination;

class ListEntiteEmmeteurs extends Component
{
    use WithPagination;

    protected EntiteEmmeteursService $service;

    public $query = '';

    public function boot(EntiteEmmeteursService $service)
    {
        $this->service = $service;
    }

    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.list-entite-emmeteurs', [
            'entiteEmmeteurs' => $this->service->search($this->query)
        ]);
    }
}
