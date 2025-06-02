<?php

namespace App\Livewire;

use App\Models\Certificate;
use Flux\Flux;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class CertificateDetails extends Component
{
    public ?Certificate $certificate = null;

    #[On('showCertificatInModal')]
    public function showCertificatInModal($id): void
    {
        $this->certificate = Certificate::find($id);
        Flux::modal('show-certificate')->show();
    }


    /**
     * Close the certificate modal
     */
    public function closeModal(): void
    {
        Flux::modal('show-certificate')->close();
    }

    public function render(): Application|Factory|View
    {
        return view('livewire.certificate-details');
    }
}
