<?php

use App\Models\FormationReel;
use App\Services\Interfaces\FormationReelServiceInterface;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public ?FormationReel $formationReel = null;

    #[Rule('required|file|mimes:xlsx,xls|max:10240')]
    public $participantFile = null;

    public string $errorMessage = '';

    protected FormationReelServiceInterface $formationReelService;

    public function boot(FormationReelServiceInterface $formationReelService)
    {
        $this->formationReelService = $formationReelService;
    }

    #[On('start-add-participant')]
    public function startUploadParticipant($formationReelId)
    {
        $this->formationReel = $this->formationReelService->findFormationReelById($formationReelId);
        \Flux\Flux::modal('add-participant-modal')->show();
    }

    public function processUpload()
    {
        $this->validate();

        try {
            $value = $this->formationReelService->processParticipantsFile($this->formationReel, $this->participantFile);
            \Flux\Flux::modal('add-participant-modal')->close();
        } catch (Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
    }

}; ?>

<flux:modal name="add-participant-modal" class="max-w-2xl" variant="flyout">
    <div class="space-y-6 h-full flex flex-col p-8">
        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Ajouter des participants à la formation {{ $formationReel?->formation->titre }}
            du {{ Carbon::parse($formationReel?->date_debut)->format('d/m/Y') }}
            au {{ Carbon::parse($formationReel?->date_fin)->format('d/m/Y') }}
        </h4>
        <div class="space-y-4">
            <div class="space-y-2">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Fichier excel (xlsx, xls) en suivant
                    <flux:link class="text-emerald-600 font-bold" href="{{ route('participants.model.download') }}">ce
                        modèle
                    </flux:link>
                </h3>

                <flux:input.file name="participantFile" id="participantFile" wire:model="participantFile"/>

                @if($errorMessage)
                    <p class="mt-1 text-sm text-red-600 dark:text-red-500">
                        {!! $errorMessage !!}
                    </p>
                @endif

                @error('participantFile')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

            </div>
            <flux:button wire:click="processUpload" variant="primary" color="green" class="w-full">
                {{ __('Envoyer') }}
            </flux:button>
        </div>
    </div>
</flux:modal>
