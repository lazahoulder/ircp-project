<?php

namespace App\Livewire\Admin\Formation;

use App\Services\FormationService;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormationForm extends Component
{
    use WithFileUploads;
    // Form properties
    public string $titre = '';
    public string $description = '';
    public ?int $entite_emmeteur_id = null;
    public ?int $expiration_year = null;
    public $modele_certificat = null;

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

        $rules['modele_certificat'] = ['file', 'mimes:doc,docx'];


        return $rules;
    }

    public function boot(FormationService $formationService)
    {
        $this->formationService = $formationService;
    }

    public function mount($formationId = null)
    {

    }

    public function resetForm()
    {
        $this->titre = '';
        $this->description = '';
        $this->expiration_year = null;
        $this->modele_certificat = null;
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

            $this->formationService->createFormation($data, $this->modele_certificat);

            $this->resetForm();
            $this->dispatch('formation-created');
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
