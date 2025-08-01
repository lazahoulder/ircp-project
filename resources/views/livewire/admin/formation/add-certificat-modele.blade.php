<?php

use App\Models\Formation;
use App\Services\FormationService;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public $formation;
    public $modele_certificat = null;
    public string $errorMessage = '';

    protected FormationService $formationService;

    public function boot(FormationService $formationService)
    {
        $this->formationService = $formationService;
    }

    public function rules()
    {
        return [
            'modele_certificat' => ['file', 'mimes:doc,docx'],
        ];;
    }


    #[On('add-certificate-model')]
    public function addCertificatModel($formationId)
    {
        $this->formation = $this->formationService->findFormationById($formationId);
        \Flux\Flux::modal('add-certificat-modal')->show();
    }

    public function uploadCertificateModele(): void
    {
        $this->validate();
        $this->errorMessage = '';

        try {
            $this->formationService->addCertificatModele($this->formation, $this->modele_certificat);
            \Flux\Flux::modal('add-certificat-modal')->close();
            LivewireAlert::title('Modèle ajouté')
                ->success()
                ->show();
            $this->dispatch('formation-created');
        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
    }
}; ?>


<flux:modal name="add-certificat-modal" class="max-w-2xl" variant="flyout">
    <div class="space-y-6 h-full flex flex-col p-8">
        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ $formation?->modele_certificat ? 'Modifier' : 'Ajouter' }} le modèle de certificat pour la
            formation {{ $formation?->titre }}
        </h4>
        <div class="space-y-4">
            <div class="space-y-2">
                <label for="modele_certificat"
                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('Modèle de certificat') }} <span class="text-red-500">*</span>
                </label>

                <flux:input.file name="modele_certificat" id="modele_certificat" wire:model="modele_certificat"/>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Fichier Word uniquement (.doc, .docx)') }}
                </p>
                @if($errorMessage)
                    <p class="mt-1 text-sm text-red-600 dark:text-red-500">
                        {{!! $errorMessage !!}}
                    </p>
                @endif

                @error('modele_certificat')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror

                @if($formation?->modele_certificat)
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Fichier actuel') }}:
                        <a href="{{ Storage::url($formation->modele_certificat) }}" target="_blank"
                           class="text-blue-600 hover:underline">
                            {{ basename($formation->modele_certificat) }}
                        </a>
                    </p>
                @endif
            </div>
            <flux:button wire:click="uploadCertificateModele" variant="primary" color="green" class="w-full">
                {{ __('Envoyer') }}
            </flux:button>
        </div>
    </div>
</flux:modal>


