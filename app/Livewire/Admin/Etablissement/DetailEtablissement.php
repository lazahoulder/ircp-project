<?php

namespace App\Livewire\Admin\Etablissement;

use App\Livewire\CenterDetails;
use App\Models\EntiteEmmeteurs;
use App\Services\EntiteEmmeteursService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\On;

#[Layout('components.layouts.app')]
class DetailEtablissement extends CenterDetails
{
    #[On('profile-updated')]
    public function handleReboot()
    {
        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('livewire.admin.etablissement.detail-etablissement', [
            'center' => $this->center,
            'formations' => $this->center ? $this->center->formations : collect([])
        ]);
    }
}
