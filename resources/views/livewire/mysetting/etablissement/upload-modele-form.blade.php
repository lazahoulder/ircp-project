<?php

use App\Models\EntiteEmmeteurs;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public EntiteEmmeteurs $entiteEmmeteurs;

    #[Validate('image|max:1024')]
    public $modelCertificat;

    public function saveModelCertificate()
    {
        $this->modelCertificat->store(path: 'models');
    }


}; ?>

<div>
    <flux:modal name="upload-logo" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
        <form wire:submit="saveLogo" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Téléverser son logo') }}</flux:heading>
            </div>
            <div>
                @if ($photo)
                    <img src="{{ $logo->temporaryUrl() }}">
                @endif
            </div>

            <flux:input wire:model="logo" :label="__('Mon logo')" type="file"/>

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>

                <flux:button variant="success" type="submit">{{ __('Envoyer mon Logo') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
