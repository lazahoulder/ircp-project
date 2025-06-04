<?php

use Livewire\Volt\Component;
use App\Models\Formation;
use App\Models\EntiteEmmeteurs;
use App\Services\Interfaces\FormationServiceInterface;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;

new class extends Component {
    use WithPagination, WithFileUploads;

    public ?Formation $formation = null;
    public bool $isEditing = false;
    public bool $isCreating = false;
    public bool $showFormationReels = false;
    public ?int $selectedFormationId = null;
    public string $errorMessage = '';

    // Form properties
    public string $titre = '';
    public string $description = '';
    public ?int $entite_emmeteur_id = null;
    public ?int $expiration_year = null;
    public $modele_certificat = null;

    // Search
    public string $search = '';

    // Services
    protected FormationServiceInterface $formationService;

    public function boot(FormationServiceInterface $formationService)
    {
        $this->formationService = $formationService;
    }

    public function rules()
    {
        $rules = [
            'titre' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'entite_emmeteur_id' => ['required', 'exists:entite_emmeteurs,id'],
            'expiration_year' => ['nullable', 'integer', 'min:0'],
        ];

        if ($this->isCreating) {
            $rules['modele_certificat'] = ['required', 'file', 'mimes:doc,docx'];
        } elseif ($this->isEditing && $this->modele_certificat) {
            $rules['modele_certificat'] = ['file', 'mimes:doc,docx'];
        }

        return $rules;
    }

    public function mount()
    {
        $this->entite_emmeteur_id = Auth::user()->entiteEmmeteur->id ?? null;
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

    public function createFormation()
    {
        $this->resetForm();
        $this->isCreating = true;
        $this->isEditing = false;
        $this->showFormationReels = false;
        $this->selectedFormationId = null;
    }

    public function storeFormation()
    {
        $this->validate();
        $this->errorMessage = '';

        try {
            $data = [
                'titre' => $this->titre,
                'description' => $this->description,
                'entite_emmeteur_id' => $this->entite_emmeteur_id,
                'expiration_year' => $this->expiration_year,
            ];

            $this->formationService->createFormation($data, $this->modele_certificat);

            $this->isCreating = false;
            $this->resetForm();
            $this->dispatch('formation-created');
        } catch (\Exception $e) {
            // Handle template validation exceptions
            $this->errorMessage = $e->getMessage();
        }
    }

    public function editFormation($formationId)
    {
        $formation = $this->formationService->findFormationById($formationId);
        if (!$formation) {
            return;
        }

        $this->formation = $formation;
        $this->titre = $formation->titre;
        $this->description = $formation->description;
        $this->entite_emmeteur_id = $formation->entite_emmeteur_id;
        $this->expiration_year = $formation->expiration_year;
        // We don't set modele_certificat here because it's a file upload field
        // and we can't set it directly. We'll display the current file name in the form.

        $this->isEditing = true;
        $this->isCreating = false;
        $this->showFormationReels = false;
        $this->selectedFormationId = $formation->id;
    }

    public function updateFormation()
    {
        $this->validate();
        $this->errorMessage = '';

        try {
            $data = [
                'titre' => $this->titre,
                'description' => $this->description,
                'entite_emmeteur_id' => $this->entite_emmeteur_id,
                'expiration_year' => $this->expiration_year,
            ];

            $this->formationService->updateFormation(
                $this->formation->id,
                $data,
                is_object($this->modele_certificat) ? $this->modele_certificat : null
            );

            $this->isEditing = false;
            $this->dispatch('formation-updated');
        } catch (\Exception $e) {
            // Handle template validation exceptions
            $this->errorMessage = $e->getMessage();
        }
    }

    public function cancelEdit()
    {
        $this->isEditing = false;
        $this->isCreating = false;
        $this->resetForm();
    }

    public function viewFormationReels($formationId)
    {
        $formation = $this->formationService->findFormationById($formationId);
        if (!$formation) {
            return;
        }

        $this->formation = $formation;
        $this->selectedFormationId = $formation->id;
        $this->showFormationReels = true;
        $this->isEditing = false;
        $this->isCreating = false;
    }

    #[On('realizationAdded')]
    public function refreshFormationReels($formationId)
    {
        if ($this->selectedFormationId == $formationId) {
            $this->formation = $this->formationService->findFormationById($formationId);
        }
    }

    public function render(): mixed
    {
        $entiteEmmeteurId = Auth::user()->entiteEmmeteur->id ?? null;
        $formations = $this->formationService->searchFormations($this->search, $entiteEmmeteurId, 10);

        return view('livewire.formation.gestion-formations', [
            'formations' => $formations,
            'entiteEmmeteurs' => EntiteEmmeteurs::all(),
        ]);
    }
}; ?>

<div>
    <section class="max-w-8xl mx-auto p-10 lg:pl-40 lg:pr-40 md:pl-15 md:pr-15 sm:pl-10 sm:pr-10 h-full min-h-screen">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold">Gestion des Formations</h1>
            <flux:button wire:click="createFormation" variant="primary" icon="plus" class="bg-green-600 hover:bg-green-700 text-white">
                {{ __('Nouvelle Formation') }}
            </flux:button>
        </div>

        <!-- Search Bar -->
        <div class="mb-6">
            <flux:input
                wire:model.debounce.300ms="search"
                type="search"
                placeholder="Rechercher des formations..."
                class="w-full"
            />
        </div>

        <!-- Create/Edit Form -->
        @if($isCreating || $isEditing)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">{{ $isCreating ? 'Créer une nouvelle formation' : 'Modifier la formation' }}</h2>

            <form wire:submit.prevent="{{ $isCreating ? 'storeFormation' : 'updateFormation' }}" class="space-y-4">
                <flux:input
                    wire:model="titre"
                    :label="__('Titre')"
                    type="text"
                    required
                    autofocus
                    :placeholder="__('Titre de la formation')"
                />

                <flux:input
                    wire:model="description"
                    :label="__('Description')"
                    type="text"
                    required
                    :placeholder="__('Description de la formation')"
                />

                <flux:input
                    wire:model="expiration_year"
                    :label="__('Année d\'expiration (optionnel)')"
                    type="number"
                    min="0"
                    :placeholder="__('Nombre d\'années avant expiration')"
                />

                <div class="space-y-2">
                    <label for="modele_certificat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Modèle de certificat') }} <span class="text-red-500">*</span>
                    </label>
                    <input
                        wire:model="modele_certificat"
                        type="file"
                        id="modele_certificat"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        accept=".doc,.docx"
                        {{ $isCreating ? 'required' : '' }}
                    />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Fichier Word uniquement (.doc, .docx)') }}
                    </p>
                    @error('modele_certificat')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror

                    @if($isEditing && $formation->modele_certificat)
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Fichier actuel') }}:
                            <a href="{{ Storage::url($formation->modele_certificat) }}" target="_blank" class="text-blue-600 hover:underline">
                                {{ basename($formation->modele_certificat) }}
                            </a>
                        </p>
                    @endif
                </div>

                @if($errorMessage)
                    <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-md text-red-600">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">{{ __('Erreur de validation') }}</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>{{ $errorMessage }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex items-center gap-4 mt-6">
                    <div class="flex items-center justify-end space-x-3">
                        <flux:button type="submit" variant="primary" class="w-full bg-green-600 hover:bg-green-700 text-white">
                            {{ $isCreating ? __('Créer') : __('Enregistrer') }}
                        </flux:button>
                        <flux:button wire:click="cancelEdit" variant="outline" class="w-full bg-white hover:bg-gray-50 text-red-600 border-red-300 hover:border-red-400">
                            {{ __('Annuler') }}
                        </flux:button>
                    </div>

                    <x-action-message class="me-3" on="formation-created">
                        {{ __('Formation créée.') }}
                    </x-action-message>
                    <x-action-message class="me-3" on="formation-updated">
                        {{ __('Formation mise à jour.') }}
                    </x-action-message>
                </div>
            </form>
        </div>
        @endif

        <!-- Formation Reels List -->
        @if($showFormationReels && $formation)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Réalisations de la formation: {{ $formation->titre }}</h2>
                <div class="flex space-x-2">
                    <flux:button wire:click="$dispatch('openAddRealizationModal', { formationId: {{ $formation->id }} })" variant="primary" icon="plus" class="bg-green-600 hover:bg-green-700 text-white">
                        {{ __('Nouvelle Réalisation') }}
                    </flux:button>
                    <flux:button wire:click="$set('showFormationReels', false)" variant="outline" icon="arrow-left" class="text-gray-600">
                        {{ __('Retour') }}
                    </flux:button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Date de début
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Date de fin
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Participants
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Créé le
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse($formation->formationReels as $formationReel)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $formationReel->date_debut }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $formationReel->date_fin }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                @if($formationReel->participants_file)
                                    <a href="{{ Storage::url($formationReel->participants_file) }}" target="_blank" class="text-blue-600 hover:underline flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                        </svg>
                                        {{ __('Télécharger') }}
                                    </a>
                                @else
                                    <span class="text-gray-400">{{ __('Non disponible') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $formationReel->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center">
                                Aucune réalisation pour cette formation
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Formations List -->
        @if(!$showFormationReels)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Titre
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Description
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Expiration (années)
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse($formations as $formation)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $formation->titre }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $formation->description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $formation->expiration_year ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <flux:button wire:click="editFormation({{ $formation->id }})" variant="outline" icon="pencil-square" class="text-blue-600 hover:text-blue-800">
                                        {{ __('Modifier') }}
                                    </flux:button>
                                    <flux:button wire:click="viewFormationReels({{ $formation->id }})" variant="outline" icon="eye" class="text-green-600 hover:text-green-800">
                                        {{ __('Réalisations') }}
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center">
                                Aucune formation trouvée
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4">
                {{ $formations->links() }}
            </div>
        </div>
        @endif
    </section>

    <!-- Modal for adding a new realization -->
    <flux:modal name="add-realization-modal" class="max-w-2xl">
        <livewire:formation.add-formation-realization />
    </flux:modal>
</div>
