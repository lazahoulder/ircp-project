<?php

namespace App\Livewire;

use App\Models\EntiteEmmeteurs;
use App\Services\EntiteEmmeteursService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('components.layouts.site.app', ['title' => 'Détails du Centre - IRCP'])]
class CenterDetails extends Component
{
    public $centerId;
    public $center;

    protected EntiteEmmeteursService $service;

    public function boot(EntiteEmmeteursService $service)
    {
        $this->service = $service;
    }

    public function mount($id)
    {
        $this->centerId = $id;
        $this->loadCenter();
    }

    public function loadCenter()
    {
        $this->center = $this->service->find($this->centerId);

        if (!$this->center) {
            return redirect()->route('centres')->with('error', 'Centre non trouvé');
        }
    }

    public function render()
    {
        return view('livewire.center-details', [
            'center' => $this->center,
            'formations' => $this->center ? $this->center->formations : collect([])
        ]);
    }
}
