<?php

namespace App\Livewire;

use App\Services\CertificateService;
use App\Services\PersonneCertifiesService;
use Livewire\Component;
use Livewire\WithPagination;

class ListCertificate extends Component
{
    use WithPagination;

    protected CertificateService $service;

    public $query = '';

    public $certificateId;

    public function boot(CertificateService $service)
    {
        $this->service = $service;
    }

    public function mount(int $certificateId = null)
    {
        $this->certificateId = $certificateId;
        $this->dispatch('showCertificatInModal', id: $this->certificateId)->to(CertificateDetails::class);;
    }

    public function search()
    {
        $this->resetPage();
    }



    public function render()
    {
        return view('livewire.list-certificate', ['certificates' => $this->service->searchCertificate($this->query)]);
    }
}
