<?php

namespace App\Livewire;

use App\Services\CertificateService;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ListCertificate extends Component
{
    use WithPagination;

    protected CertificateService $service;

    #[Url]
    public $query = '';

    public function boot(CertificateService $service)
    {
        $this->service = $service;
    }

    public function search()
    {
        $this->resetPage();
    }

    public function updatingQuery()
    {
        // Reset to initial value
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.list-certificate', ['certificates' => $this->service->searchValideCertificate($this->query)]);
    }
}
