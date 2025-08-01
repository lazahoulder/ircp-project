<?php

namespace App\Livewire\Admin\Certificate;

use App\Constant\CertificateConstant;
use App\Models\Certificate;
use App\Models\EntiteEmmeteurs;
use App\Models\Formation;
use App\Models\FormationReel;
use App\Services\CertificateService;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class ListCertificate extends Component
{
    use WithPagination;

    protected CertificateService $service;

    #[Url]
    public $query = '';

    #[Url]
    public $status = '';

    #[Url]
    public ?int $entiteEmmeteurId = null;

    #[Url]
    public ?int $formationId = null;

    public $entityChoices = [];
    public $formationChoices = [];
    public array $statusEtab = [];

    public bool $isStandAlone = true;


    public function boot(CertificateService $service)
    {
        $this->service = $service;
    }

    public function mount()
    {
        $this->entityChoices = EntiteEmmeteurs::query()->select('id', 'nomination')->get()->map(function ($item) {
            return ['id' => $item->id, 'nomination' => $item->nomination];
        })->toArray();
        if ($this->entiteEmmeteurId) {
            $this->setUpFormationChoice();
        }

        $this->statusEtab[] = CertificateConstant::STATUS_EN_ATTENTE;
        $this->statusEtab[] = CertificateConstant::STATUS_INCOMPLET;
        $this->statusEtab[] = CertificateConstant::STATUS_VALID;
    }

    public function setUpFormationChoice()
    {
        $this->formationChoices = Formation::query()
            ->select('id', 'titre')
            ->where('entite_emmeteur_id', (int) $this->entiteEmmeteurId)
            ->get()
            ->map(function ($item) {
                return ['id' => $item->id, 'titre' => $item->titre];
            })
            ->toArray();
        if (empty($this->formationChoices)) {
            $this->formationId = null;
        }
    }

    public function updatedEntiteEmmeteurId()
    {
        $this->setUpFormationChoice();
        $this->search();
    }

    public function updatingQuery()
    {
        $this->search();
    }

    public function updatedStatus()
    {
        $this->search();
    }

    public function updatedFormationId()
    {
        $this->search();
    }

    public function search()
    {
        $this->resetPage();
    }

    public function validateCertificate($id)
    {
        Certificate::find($id)->update(['status' => CertificateConstant::STATUS_VALID]);
        $this->dispatch('$refresh');
    }

    public function validateEnAttente()
    {
        $count = Certificate::query()
            ->where('status' ,CertificateConstant::STATUS_EN_ATTENTE)
            ->update(['status' => CertificateConstant::STATUS_VALID])
        ;

        $this->status = CertificateConstant::STATUS_VALID;

        $this->dispatch('$refresh');
        LivewireAlert::title('Valider les certificats en attente')
            ->text("$count certificat ont été validé")
            ->success()
            ->show();
    }

    public function render()
    {
        return view('livewire.admin.certificate.list-certificate', [
            'certificates' => $this->service->searchForAdminCertificate(
                $this->query,
                $this->entiteEmmeteurId,
                $this->formationId,
                $this->status,
            ),
            'entityChoices' => $this->entityChoices,
            'formationChoices' => $this->formationChoices,
            'statusCertificates' => $this->statusEtab,
        ]);
    }
}
