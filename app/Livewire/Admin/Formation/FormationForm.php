<?php

namespace App\Livewire\Admin\Formation;

use App\Models\EntiteEmmeteurs;
use App\Services\FormationService;
use Flux\Flux;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormationForm extends Component
{
    // Form properties
    public string $titre = '';
    public string $description = '';
    public ?int $entite_emmeteur_id = null;
    public ?int $expiration_year = null;
    public ?int $formationId = null;
    public array $entityChoices = [];

    public string $errorMessage = '';

    // Services
    protected FormationService $formationService;

    public function rules()
    {
        $rules = [
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'entite_emmeteur_id' => ['required', 'exists:entite_emmeteurs,id'],
            'expiration_year' => ['nullable', 'integer', 'min:0'],
        ];


        return $rules;
    }

    public function boot(FormationService $formationService)
    {
        $this->formationService = $formationService;
    }

    public function mount($entiteEmmeteurId = null)
    {
        $this->entite_emmeteur_id = $entiteEmmeteurId;
        $this->entityChoices = EntiteEmmeteurs::query()->select('id', 'nomination')->get()->map(function ($item) {
            return ['id' => $item->id, 'nomination' => $item->nomination];
        })->toArray();;
    }

    #[On('update-create-formation')]
    public function openFormCreate($entiteEmmeteurId = null, $formationId = null)
    {
        $this->entite_emmeteur_id = $entiteEmmeteurId;
        $this->formationId = $formationId;

        if ($formationId) {
            $formtion = $this->formationService->findFormationById($formationId);
            $this->titre = $formtion->titre;
            $this->description = $formtion->description;
            $this->expiration_year = $formtion->expiration_year;
        }

        Flux::modal('formation-modal')->show();
    }

    public function cancelEdit()
    {
        $this->resetForm();
        Flux::modal('formation-modal')->close();
    }



    public function resetForm()
    {
        $this->titre = '';
        $this->description = '';
        $this->expiration_year = null;
        $this->errorMessage = '';
        $this->resetValidation();
    }

    public function storeFormation()
    {
        $this->validate();
        $this->errorMessage = '';

        try {
            // Create the formation using the service
            $data = [
                'titre' => $this->titre,
                'description' => $this->description,
                'entite_emmeteur_id' => $this->entite_emmeteur_id,
                'expiration_year' => $this->expiration_year,
            ];

            if ($this->formationId) {
                $this->formationService->updateFormation($this->formationId, $data);
            } else {
                $this->formationService->createFormation($data);
            }


            $this->resetForm();
            $this->dispatch('formation-created');
            $this->cancelEdit();
            LivewireAlert::title($this->formationId ? 'Formation modifié' : 'Formation ajouté')
                ->success()
                ->show();
        } catch (\Exception $e) {
            // Handle template validation exceptions
            $this->errorMessage = $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.admin.formation.formation-form');
    }
}
