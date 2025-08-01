<?php

use App\Services\FormationReelService;
use Livewire\Volt\Component;
use App\Models\Formation;
use App\Models\EntiteEmmeteurs;
use App\Services\FormationService;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Carbon\Carbon;

new class extends Component {
    use WithPagination, WithFileUploads;

    #[On('openImportModal')]
    public function openImportModal()
    {
        //$this->dispatch('modal.open', ['name' => 'import-modal']);
        Flux::modal('import-modal')->show();
    }

    #[On('formations-imported')]
    public function refreshAfterImport()
    {
        // Close the modal
        Flux::modal('import-modal')->close();

        // Show a notification
        session()->flash('message', 'Formations importées avec succès');
    }

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

    // Services
    protected FormationService $formationService;
    protected FormationReelService $formationReelService;

    // Search
    public string $search = '';

    public function updatingSearch()
    {
        $this->searchData();
    }

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

    #[On('formation-created')]
    public function refreshData()
    {
        $this->dispatch('$refresh');
    }

    public function boot(FormationService $formationService, FormationReelService $formationReelService)
    {
        $this->formationService = $formationService;
        $this->formationReelService = $formationReelService;
    }

    public function mount(?EntiteEmmeteurs $centre)
    {
        $this->entite_emmeteur_id = $centre?->id;
    }

    public function editFormation(Formation $formation)
    {
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

    public function viewFormationReels(Formation $formation)
    {
        $this->formation = $formation;
        $this->selectedFormationId = $formation->id;
        $this->showFormationReels = true;
        $this->isEditing = false;
        $this->isCreating = false;
    }

    /**
     * Effectue une recherche avec le terme saisi
     */
    public function searchData()
    {
        $this->resetPage(); // Réinitialise la pagination lors d'une nouvelle recherche
        // La recherche est gérée automatiquement par Livewire grâce au wire:model="search"
        // Cette méthode est appelée lorsque l'utilisateur clique sur le bouton de recherche
    }

    #[On('realizationAdded')]
    public function refreshFormationReels($formationId)
    {
        if ($this->selectedFormationId == $formationId) {
            $this->formation = Formation::find($formationId);
        }
    }

    public function regenerateQrCode($formationReelId)
    {
        $this->formationReelService->regenerateQrCodeParticipants($formationReelId);
    }

    public function addCertificateModele($formationId)
    {
        $this->dispatch('add-certificate-model', formationId: $formationId);
    }

    public function voirParticipant($formationReelId)
    {
        $this->dispatch('open-search', id: $formationReelId);
    }

    public function render(): mixed
    {
        $formations = $this->formationService->searchFormations($this->search, $this->entite_emmeteur_id);

        return view('livewire.admin.formation.list-formation', [
            'formations' => $formations,
        ]);
    }
}; ?>

<div>
    <div class="space-y-6">
        <div class="flex items-left px-5">
            <flux:heading>Les formations du centre</flux:heading>
        </div>

        @if(session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                 role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif
        <!-- Search and Create Button -->
        <div class="flex gap-3 justify-between items-center mb-6">
            <div
                class="flex items-center bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-green-500/10 border border-gray-200 dark:border-gray-700 flex-1 max-w-7xl">
                <div class="flex-grow flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-4 text-gray-400" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input
                        type="text"
                        wire:model.live="search"
                        wire:keydown.enter="searchData"
                        placeholder="Rechercher des formations..."
                        class="flex-grow px-3 py-2 text-sm text-gray-800 dark:text-white bg-transparent placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-0"
                    >
                </div>
                <button
                    type="button"
                    wire:click="searchData"
                    class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium text-sm transition-all duration-300"
                >
                    Rechercher
                </button>
            </div>
            <div class="flex space-x-2">
                <flux:button wire:click="$dispatch('update-create-formation', {entiteEmmeteurId: {{ $entite_emmeteur_id }} })" variant="primary" icon="plus"
                             class="bg-green-600 hover:bg-green-700 text-white">
                    {{ __('Nouvelle Formation') }}
                </flux:button>
                <flux:button wire:click="$dispatch('openImportModal')" variant="primary" icon="arrow-up-tray"
                             class="bg-blue-600 hover:bg-blue-700 text-white">
                    {{ __('Importer') }}
                </flux:button>
            </div>
        </div>

        <!-- Formation Reels List -->
        @if($showFormationReels && $formation)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Réalisations de la formation: {{ $formation->titre }}</h2>
                    <div class="flex space-x-2">
                        <flux:button
                            wire:click="$dispatch('openAddRealizationModal', { formationId: {{ $formation->id }} })"
                            variant="primary" icon="plus" class="bg-green-600 hover:bg-green-700 text-white">
                            {{ __('Nouvelle Réalisation') }}
                        </flux:button>
                        <flux:button wire:click="$set('showFormationReels', false)" variant="outline" icon="arrow-left"
                                     class="text-gray-600">
                            {{ __('Retour') }}
                        </flux:button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Date de début
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Date de fin
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Participants
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @forelse($formation->formationReels as $formationReel)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ Carbon::parse($formationReel->date_debut)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ Carbon::parse($formationReel->date_fin)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    <flux:button size="sm" wire:click="voirParticipant({{ $formationReel->id }} )"
                                                 variant="primary" icon="eye" title="Voir les participants"
                                                 class="bg-blue-600 hover:bg-blue-700 text-white">
                                    </flux:button>
                                    <flux:button size="sm" wire:click="regenerateQrCode({{ $formationReel->id }})"
                                                 variant="filled" icon="qr-code" title="Regenerer QR-CODE"
                                                 class="bg-blue-600 hover:bg-blue-700 text-white">
                                    </flux:button>
                                    <flux:button size="sm" wire:click="$dispatch('start-add-participant', { formationReelId: {{ $formationReel->id }} })"
                                                 variant="primary" icon="user-plus" title="Ajouter des participants"
                                                 color="yellow">
                                    </flux:button>

                                </td>
                                <td class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider flex justify-end">
                                    <flux:button size="sm"
                                        wire:click="$dispatch('openAddRealizationModal', { formationId: {{ $formation->id }}, formationReelId: {{ $formationReel->id }} })"
                                        variant="primary" icon="pencil" class="bg-green-600 hover:bg-green-700 text-white" title="MOdifier">
                                    </flux:button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center">
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
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Titre
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Description
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Expiration (années)
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
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
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-500 dark:text-gray-300">
                                    {{ $formation->description }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                    {{ $formation->expiration_year ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <flux:button size="xs" wire:click="$dispatch('update-create-formation', {entiteEmmeteurId: {{ $entite_emmeteur_id }}, formationId: {{ $formation->id }} })"
                                                     variant="primary"
                                                     icon="pencil-square"
                                                     color="zinc"
                                                     tooltip="Modifier"
                                        >
                                        </flux:button>
                                        <flux:button size="xs" wire:click="viewFormationReels({{ $formation->id }})"
                                                     variant="primary" icon="eye"
                                                     color="blue"
                                                     tooltip="Voir les réalisations"
                                        >
                                        </flux:button>
                                        <flux:button size="xs" wire:click="addCertificateModele({{ $formation->id }})"
                                                     variant="primary" icon="document"
                                                     color="{{ $formation->modele_certificat? 'orange' : 'green' }}"
                                                     tooltip="{{ $formation->modele_certificat? 'Modifier' : 'Ajouter' }} le modèle de certificat"
                                        >
                                        </flux:button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center">
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
    </div>

    <!-- Modal for importing formations -->
    <flux:modal name="import-modal" class="max-w-2xl" variant="flyout">
        <livewire:admin.formation.import-formation :entiteEmmeteurId="$entite_emmeteur_id"/>
    </flux:modal>

    <!-- Modal for adding a new realization -->
    <flux:modal name="add-realization-modal" class="max-w-2xl"  variant="flyout">
        <livewire:formation.add-formation-realization/>
    </flux:modal>
    <flux:modal name="formation-modal" class="max-w-2xl"  variant="flyout">
        <livewire:admin.formation.formation-form/>
    </flux:modal>
    <div>
        <livewire:admin.formation.add-certificat-modele/>
        <livewire:admin.formation.add-participant/>
    </div>
    <flux:modal name="show-participants" class="max-w-4xl md:max-w-5xl lg:max-w-6xl xl:max-w-7xl mx-auto">
        <livewire:admin.formation.participants/>
    </flux:modal>
</div>
