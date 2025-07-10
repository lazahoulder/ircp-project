<?php

namespace App\Livewire\Admin\Etablissement;

use App\Models\EntiteEmmeteurs;
use App\Services\EntiteEmmeteursService;
use Flux\Flux;
use Livewire\Component;
use Livewire\Features\SupportRedirects\HandlesRedirects;

class FormEtablissemet extends Component
{
    use HandlesRedirects;

    public ?EntiteEmmeteurs $entiteEmmeteur = null;
    public bool $isEditing = true;

    // Individual properties for form binding
    public ?string $nomination = null;
    public ?string $adresse = null;
    public ?string $date_creation = null;
    public ?string $nif = null;
    public ?string $stat = null;
    protected EntiteEmmeteursService $service;
    public string $modalName = 'edit-center';

    public function rules()
    {
        return [
            'nomination' => ['required', 'string', 'max:255'],
            'adresse' => ['nullable', 'string', 'max:255'],
            'date_creation' => ['nullable', 'date'],
            'nif' => ['nullable', 'string', 'max:50'],
            'stat' => ['nullable', 'string', 'max:50'],
        ];
    }

    public function boot(EntiteEmmeteursService $service)
    {
        $this->service = $service;
    }

    public function mount(?EntiteEmmeteurs $center = null, ?string $modalName = 'edit-center')
    {
        $this->entiteEmmeteur = $center;
        $this->modalName = $modalName;

        if (!$this->entiteEmmeteur->id) {
            $this->entiteEmmeteur = new EntiteEmmeteurs();
            $this->isEditing = false;
        }

        // Set individual properties from entiteEmmeteur
        $this->nomination = $this->entiteEmmeteur->nomination ?? null;
        $this->adresse = $this->entiteEmmeteur->adresse ?? null;
        $this->date_creation = $this->entiteEmmeteur->date_creation ?? null;
        $this->nif = $this->entiteEmmeteur->nif ?? null;
        $this->stat = $this->entiteEmmeteur->stat ?? null;
    }

    public function saveEtab()
    {
        $this->validate();

        // Update entiteEmmeteur with form values
        $this->entiteEmmeteur->nomination = $this->nomination;
        $this->entiteEmmeteur->adresse = $this->adresse;
        $this->entiteEmmeteur->date_creation = $this->date_creation;
        $this->entiteEmmeteur->nif = $this->nif;
        $this->entiteEmmeteur->stat = $this->stat;

        $this->entiteEmmeteur->save();

        if ($this->isEditing) {
            $this->dispatch('profile-updated');
            Flux::modal($this->modalName)->close();
        } else {
            $this->redirectRoute('admin.etablissements-details', $this->entiteEmmeteur->id);
        }
    }

    public function cancelEdit()
    {
        Flux::modal($this->modalName)->close();
    }

    public function render()
    {
        return view('livewire.admin.etablissement.form-etablissemet');
    }
}
