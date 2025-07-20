<?php

namespace App\Livewire;

use App\Models\Certificate;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Livewire\Component;

class CertificateDetails extends Component
{
    public ?Certificate $certificate = null;

    public function mount(Certificate $id): void
    {
        $this->certificate = $id;
    }


    public function render(): Application|Factory|View
    {
        return view('livewire.certificate-details');
    }
}
