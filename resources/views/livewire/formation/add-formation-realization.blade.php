<?php

use App\Models\Formation;
use App\Models\FormationReel;
use App\Services\Interfaces\FormationServiceInterface;
use App\Services\Interfaces\FormationReelServiceInterface;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use Flux\Flux;

new class extends Component {
    use WithFileUploads;

    public ?int $formationReelId = null;
    public ?Formation $formation = null;
    public ?int $formationId = null;
    public $date_debut = null;
    public $date_fin = null;

    // Services
    protected FormationServiceInterface $formationService;
    protected FormationReelServiceInterface $formationReelService;

    public function boot(
        FormationServiceInterface     $formationService,
        FormationReelServiceInterface $formationReelService
    )
    {
        $this->formationService = $formationService;
        $this->formationReelService = $formationReelService;
    }

    public function rules()
    {
        return [
            'formationId' => ['required', 'exists:formations,id'],
            'date_debut' => ['required', 'date'],
            'date_fin' => ['required', 'date', 'after_or_equal:date_debut'],
        ];
    }

    #[On('openAddRealizationModal')]
    public function openModal($formationId, $formationReelId = null): void
    {
        if ($formationReelId) {
            $formationReel = $this->formationReelService->findFormationReelById($formationReelId);
            $this->date_debut = $formationReel->date_debut;
            $this->date_fin = $formationReel->date_fin;
            $this->formationReelId = $formationReelId;
        } else {
            $this->reset(['date_debut', 'date_fin', 'formationReelId']);
        }
        $this->formationId = $formationId;
        $this->formation = $this->formationService->findFormationById($formationId);
        Flux::modal('add-realization-modal')->show();
    }

    public function saveRealization()
    {
        $this->validate();

        try {
            if ($this->formationReelId) {
                $this->formationReelService->updateFormationReel(
                    $this->formationReelId,
                    [
                        'date_debut' => $this->date_debut,
                        'date_fin' => $this->date_fin
                    ]
                );
            } else {
                // Create a new FormationReel and process the participants file
                $this->formationReelService->createFormationReel(
                    $this->formationId,
                    $this->date_debut,
                    $this->date_fin
                );
            }

            // Reset the form
            $this->reset(['date_debut', 'date_fin']);

            // Close the modal
            Flux::modal('add-realization-modal')->close();

            // Dispatch an event to refresh the formation reels list
            $this->dispatch('realizationAdded', $this->formationId);

        } catch (\Exception $e) {
            $this->addError('excelFile', 'Erreur lors du traitement du fichier: ' . $e->getMessage());
        }
    }

    public function render(): mixed
    {
        return view('livewire.formation.add-formation-realization');
    }
}; ?>

<div>
    <form wire:submit.prevent="saveRealization" class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('Ajouter une réalisation de formation') }}</flux:heading>
            @if($formation)
                <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $formation->titre }}</p>
            @endif
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Date Fields -->
        <div class="gap-4">
            <flux:input
                wire:model="date_debut"
                :label="__('Date de début')"
                type="date"
                class="p-2"
                required
            />

            <flux:input
                wire:model="date_fin"
                :label="__('Date de fin')"
                type="date"
                class="p-2"
                required
            />
        </div>

        <!-- Buttons -->
        <div class="flex justify-end space-x-2 rtl:space-x-reverse">
            {{--<flux:button wire:click="$dispatch('close-modal', { name: 'add-realization-modal' })" variant="filled">
                {{ __('Annuler') }}
            </flux:button>--}}
            <flux:button variant="primary" type="submit">
                {{ __('Enregistrer') }}
            </flux:button>
        </div>
    </form>
</div>
