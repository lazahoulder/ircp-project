<?php

namespace App\Livewire\Admin\Dashboard;

use App\Services\EntiteEmmeteursService;
use Livewire\Component;

class CenterCount extends Component
{
    protected EntiteEmmeteursService $service;

    public function boot(EntiteEmmeteursService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        return view('livewire.admin.dashboard.center-count');
    }
}
