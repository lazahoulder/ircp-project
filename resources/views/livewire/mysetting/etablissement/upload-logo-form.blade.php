<?php

use App\Models\EntiteEmmeteurs;
use App\Models\Image;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {

    use WithFileUploads;

    public EntiteEmmeteurs $entiteEmmeteur;

    #[Validate('image|max:6024')]
    public $logo;

    public function mount(EntiteEmmeteurs $entiteEmmeteur)
    {
        $this->entiteEmmeteur = $entiteEmmeteur;
    }

    public function saveLogo()
    {
        $this->validate();

        // Store the file and get its path
        $fileName = $this->logo->getClientOriginalName();
        $filePath = $this->logo->store('logos', 'public');

        // Create a new Image record
        $image = Image::create([
            'file_name' => $fileName,
            'file_path' => $filePath,
        ]);

        // Update the EntiteEmmeteurs record with the image_id
        $this->entiteEmmeteur->image_id = $image->id;
        $this->entiteEmmeteur->save();

        // Reset the form and show success message
        $this->reset('logo');
        session()->flash('message', __('Logo téléversé avec succès!'));

        //Close Modal
        \Flux\Flux::modal('upload-logo')->close();
    }

}; ?>

<div>
    <!-- Success Message -->

    <!-- Current Logo Preview (if exists) -->


    <!-- Logo with edit button -->
    <div class="mb-8 text-center relative">
        @if ($entiteEmmeteur->image)
            <div class="mb-4">
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $entiteEmmeteur->image->file_path) }}"
                         alt="{{ $entiteEmmeteur->nomination }}"
                         class="h-48 w-48 object-contain bg-white rounded-xl p-2">
                </div>
            </div>
        @else
            <svg class="w-60 h-auto mx-auto" width="116" height="50" viewBox="0 0 116 32" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <g id="logogram" transform="translate(0, 1) rotate(0)">
                    <path class="fill-blue-500 dark:fill-blue-500" fill="currentColor"
                          d="M16 0C7.163 0 0 7.163 0 16C0 24.837 7.163 32 16 32C24.837 32 32 24.837 32 16C32 7.163 24.837 0 16 0ZM16 28C9.373 28 4 22.627 4 16C4 9.373 9.373 4 16 4C22.627 4 28 9.373 28 16C28 22.627 22.627 28 16 28Z"/>
                </g>
                <g id="logotype" transform="translate(33, 8)">
                    <path class="fill-black dark:fill-white"
                          d="M8.31 0.54L13.52 0.54L13.52 26L8.31 26L8.31 0.54ZM21.07 26L15.86 26L15.86 0.54L25.79 0.54Q28.69 0.54 30.73 1.56Q32.76 2.59 33.83 4.45Q34.90 6.31 34.90 8.82L34.90 8.82Q34.90 11.34 33.81 13.16Q32.73 14.98 30.67 15.94Q28.61 16.91 25.67 16.91L25.67 16.91L18.93 16.91L18.93 12.69L24.83 12.69Q26.44 12.69 27.46 12.25Q28.49 11.82 29.00 10.95Q29.51 10.09 29.51 8.82L29.51 8.82Q29.51 7.53 29.00 6.65Q28.49 5.77 27.45 5.30Q26.42 4.84 24.81 4.84L24.81 4.84L21.07 4.84L21.07 26ZM35.80 26L30.03 26L23.82 14.41L29.48 14.41L35.80 26ZM47.70 26.34L47.70 26.34Q44.31 26.34 41.64 24.80Q38.96 23.27 37.42 20.34Q35.87 17.42 35.87 13.29L35.87 13.29Q35.87 9.13 37.42 6.20Q38.98 3.27 41.66 1.73Q44.35 0.19 47.70 0.19L47.70 0.19Q49.87 0.19 51.74 0.80Q53.61 1.41 55.06 2.57Q56.51 3.73 57.44 5.42Q58.36 7.10 58.65 9.23L58.65 9.23L53.37 9.23Q53.20 8.19 52.71 7.38Q52.22 6.57 51.50 6.00Q50.77 5.42 49.83 5.12Q48.89 4.83 47.80 4.83L47.80 4.83Q45.82 4.83 44.31 5.82Q42.81 6.81 41.99 8.70Q41.17 10.58 41.17 13.29L41.17 13.29Q41.17 16.04 42.00 17.92Q42.84 19.80 44.33 20.75Q45.82 21.71 47.78 21.71L47.78 21.71Q48.87 21.71 49.81 21.41Q50.74 21.11 51.48 20.54Q52.22 19.97 52.71 19.15Q53.20 18.33 53.39 17.30L53.39 17.30L58.67 17.30Q58.46 19.06 57.62 20.69Q56.77 22.31 55.37 23.59Q53.97 24.87 52.04 25.61Q50.10 26.34 47.70 26.34ZM65.40 26L60.19 26L60.19 0.54L70.11 0.54Q73.02 0.54 75.05 1.64Q77.09 2.74 78.16 4.68Q79.22 6.62 79.22 9.13L79.22 9.13Q79.22 11.66 78.14 13.58Q77.05 15.51 74.99 16.59Q72.93 17.68 70.00 17.68L70.00 17.68L63.60 17.68L63.60 13.47L69.16 13.47Q70.76 13.47 71.80 12.92Q72.83 12.36 73.34 11.39Q73.84 10.41 73.84 9.13L73.84 9.13Q73.84 7.85 73.34 6.88Q72.83 5.90 71.79 5.37Q70.75 4.84 69.14 4.84L69.14 4.84L65.40 4.84L65.40 26Z"/>
                </g>
            </svg>
        @endif

        <div class="mt-4">
            <flux:modal.trigger name="upload-logo">
                <flux:button
                    variant="outline"
                    icon="photo"
                    size="sm"
                    class="px-3 py-1.5 text-sm"
                >
                    {{ __('Modifier le logo') }}
                </flux:button>
            </flux:modal.trigger>
        </div>
    </div>


    <!-- Upload Modal -->
    <flux:modal name="upload-logo" :show="$errors->isNotEmpty()" focusable class="max-w-2xl" variant="flyout">
        <form wire:submit="saveLogo" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Téléverser son logo') }}</flux:heading>
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
                @if ($logo)
                    <div class="mt-2 flex justify-center">
                        <img src="{{ $logo->temporaryUrl() }}"
                             alt="Logo Preview"
                             class="h-32 w-auto object-contain border rounded p-1">
                    </div>
                @endif
            </div>

            <!-- File Input -->
            <flux:input wire:model="logo" :label="__('Mon logo')" type="file" accept="image/*"/>

            <!-- Buttons -->
            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Annuler') }}</flux:button>
                </flux:modal.close>

                <flux:button variant="primary" type="submit">{{ __('Envoyer mon Logo') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
