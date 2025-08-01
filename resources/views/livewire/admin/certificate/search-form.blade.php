<?php

use App\Constant\CertificateConstant;
use App\Models\EntiteEmmeteurs;
use App\Models\Formation;
use Livewire\Attributes\Url;
use Livewire\Volt\Component;

new class extends Component {

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
        $this->launchSearch();
    }

    public function updatingQuery()
    {
        $this->launchSearch();
    }

    public function updatedStatus()
    {
        $this->launchSearch();
    }

    public function updatedFormationId()
    {
        $this->launchSearch();
    }

    public function search()
    {
        $this->launchSearch();
    }

    public function launchSearch()
    {
        //dd('laza');
        $this->dispatch('search-certificate', data: [
            'query' => $this->query,
            'status' => $this->status,
            'entiteEmmeteurId' => $this->entiteEmmeteurId,
            'formationId' => $this->formationId
        ]);
    }

}; ?>

<div class="flex w-full space-x-3 items-center">
    <!-- Groupe Recherche + Bouton Rechercher -->
    <div class="flex flex-1 items-stretch rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-md min-w-0">
        <div class="flex items-center px-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <input
            type="text"
            wire:model.live="query"
            wire:keydown.enter="launchSearch"
            placeholder="Nom du centre ou adresse..."
            class="flex-grow px-3 py-2 text-sm text-gray-800 dark:text-white bg-transparent placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-0"
        />
        <button
            type="button"
            wire:click="search"
            class="px-4 bg-green-500 hover:bg-green-600 text-white text-sm font-medium transition-all duration-300"
        >
            Rechercher
        </button>
    </div>

    <!-- Sélecteur de statut -->
    <div class="flex-shrink-0 w-64">
        <flux:select
            wire:model.live="status"
            class="w-full h-full px-3 py-2 text-sm text-gray-800 dark:text-white bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg focus:outline-none"
        >
            <flux:select.option value="">Statut du certificat</flux:select.option>
            @foreach($statusEtab as $etat)
                <flux:select.option value="{{ $etat }}">{{ $etat }}</flux:select.option>
            @endforeach
        </flux:select>
    </div>

    <!-- Sélecteur de centre de formation -->
    <div class="flex-shrink-0 w-64">
        <flux:select
            wire:model.live="entiteEmmeteurId"
            class="w-full h-full px-3 py-2 text-sm text-gray-800 dark:text-white bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg focus:outline-none"
        >
            <flux:select.option value="">Centre de formation</flux:select.option>
            @foreach($entityChoices as $entity)
                <flux:select.option value="{{ $entity['id'] }}">{{ $entity['nomination'] }}</flux:select.option>
            @endforeach
        </flux:select>
    </div>

    @if(!empty($formationChoices))
        <div class="flex-shrink-0 w-64">
            <flux:select
                wire:model.live="formationId"
                class="w-full h-full px-3 py-2 text-sm text-gray-800 dark:text-white bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg focus:outline-none"
            >
                <flux:select.option value="">Formation</flux:select.option>
                @foreach($formationChoices as $formation)
                    <flux:select.option value="{{ $formation['id'] }}">{{ $formation['titre'] }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>
    @endif
</div>
