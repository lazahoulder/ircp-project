<?php

namespace App\Livewire\Admin;

use App\Services\Interfaces\FormationServiceInterface;
use Livewire\Component;
use Livewire\WithPagination;

class FormationsCentre extends Component
{
    use WithPagination;

    public int $centreId;
    public string $query = '';
    protected FormationServiceInterface $service;

    public function boot(FormationServiceInterface $service)
    {
        $this->service = $service;
    }

    public function mount($centreId): void
    {
        $this->centreId = $centreId;
    }

    public function search(): void
    {
        $this->resetPage();
    }
    public function render()
    {
        return view('livewire.admin.formations-centre', [
            'formations' => $this->service->searchFormations($this->query, $this->centreId)
        ]);
    }
}
