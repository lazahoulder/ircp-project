<?php

use App\Models\Certificate;
use App\Models\EntiteEmmeteurs;
use Carbon\Carbon;
use App\Models\Image;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

new class extends Component {

    use WithFileUploads;

    public Certificate $certificate;

    #[Validate('image|max:6024')]
    public $photo;

    public function mount(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    public function savePhoto()
    {
        $this->validate();

        // Store the file and get its path
        // Store the file and get its path
        $fileName = $this->photo->getClientOriginalName();
        $filePath = $this->photo->store('images', 'public');

        // Create a new Image record
        $image = Image::create([
            'file_name' => $fileName,
            'file_path' => $filePath,
        ]);


        $this->certificate->image_id = $image->id;
        $this->certificate->status = \App\Constant\CertificateConstant::STATUS_EN_ATTENTE;
        $this->certificate->save();

        // Reload the certificate
        $this->certificate = $this->certificate->fresh(['image']);

        // Close Modal
        \Flux\Flux::modal('upload-photo')->close();

        $this->reset('photo');

        // Dispatch custom event
        $this->dispatch('image-updated');

        LivewireAlert::title('Photos')
            ->text('L\'image a été mise à jour')
            ->success()
            ->show();
    }

}; ?>

<div>
    <div class="mb-6 flex items-center">
        <!-- Photo du titulaire -->
        <div class="mr-4" wire:init="$refresh" wire:image-updated="$refresh">
            <!-- Existing image code -->
            @if($certificate->getImage())
                @php($pathIage = $certificate->image ? $certificate->image->file_path : $certificate->personneCertifies->image->file_path)
                <img
                    src="{{ asset('storage/' . $pathIage) }}"
                    alt="{{ $certificate->personneCertifies->nom }}"
                    class="h-20 w-20 object-cover rounded-full border-2 border-blue-500">
            @else
                <div
                    class="h-20 w-20 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-10 w-10 text-gray-400 dark:text-gray-500" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            @endif
            <!-- Rest of your view -->
        </div>

        <div>
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Titulaire du
                certificat</h3>
            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $certificate->personneCertifies->prenom }} {{ $certificate->personneCertifies->nom }}</p>
        </div>
    </div>

    <!-- Formulaire pour modifier la photo -->
    <div class="mt-4 mb-6 flex">
        <flux:modal.trigger name="upload-photo">
            <flux:button
                variant="outline"
                icon="photo"
                size="sm"
                class="px-3 py-1.5 text-sm"
            >
                {{ __('Modifier la photo') }}
            </flux:button>
        </flux:modal.trigger>
    </div>

    <flux:modal name="upload-photo" :show="$errors->isNotEmpty()" class="max-w-2xl" variant="flyout">
        <form wire:submit="savePhoto" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Téléverser l\'image') }}</flux:heading>
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

            <!-- Logo Preview -->
            <div>
                @if ($photo)
                    <div class="mt-2 flex justify-center">
                        <img src="{{ $photo->temporaryUrl() }}"
                             alt="photo Preview"
                             class="h-32 w-auto object-contain border rounded p-1">
                    </div>
                @endif
            </div>

            <!-- File Input -->
            <flux:input wire:model="photo" :label="__('Mon photo')" type="file" accept="image/*"/>

            <!-- Buttons -->
            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Annuler') }}</flux:button>
                </flux:modal.close>

                <flux:button variant="primary" type="submit">{{ __('Envoyer mon photo') }}</flux:button>
            </div>
        </form>
    </flux:modal>

</div>
