<?php

use Livewire\Volt\Component;
use App\Models\EntiteEmmeteurs;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public EntiteEmmeteurs $entiteEmmeteur;
    public bool $isEditing = false;

    // Individual properties for form binding
    public string $nomination = '';
    public string $adresse = '';
    public ?string $date_creation = null;
    public string $nif = '';
    public string $stat = '';

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

    public function mount()
    {
        $this->entiteEmmeteur = Auth::user()->entiteEmmeteur;

        // Set individual properties from entiteEmmeteur
        $this->nomination = $this->entiteEmmeteur->nomination ?? '';
        $this->adresse = $this->entiteEmmeteur->adresse ?? '';
        $this->date_creation = $this->entiteEmmeteur->date_creation;
        $this->nif = $this->entiteEmmeteur->nif ?? '';
        $this->stat = $this->entiteEmmeteur->stat ?? '';
    }

    public function toggleEditMode()
    {
        $this->isEditing = true;
    }

    public function cancelEdit()
    {
        $this->isEditing = false;
        // Reset form to original values
        $this->entiteEmmeteur = Auth::user()->entiteEmmeteur->fresh();

        // Reset individual properties
        $this->nomination = $this->entiteEmmeteur->nomination ?? '';
        $this->adresse = $this->entiteEmmeteur->adresse ?? '';
        $this->date_creation = $this->entiteEmmeteur->date_creation;
        $this->nif = $this->entiteEmmeteur->nif ?? '';
        $this->stat = $this->entiteEmmeteur->stat ?? '';
    }

    public function updateEtablissementInformation()
    {
        $this->validate();

        // Update entiteEmmeteur with form values
        $this->entiteEmmeteur->nomination = $this->nomination;
        $this->entiteEmmeteur->adresse = $this->adresse;
        $this->entiteEmmeteur->date_creation = $this->date_creation;
        $this->entiteEmmeteur->nif = $this->nif;
        $this->entiteEmmeteur->stat = $this->stat;

        $this->entiteEmmeteur->save();

        $this->isEditing = false;

        $this->dispatch('profile-updated');
    }

}; ?>

<section class="max-w-8xl mx-auto p-10 lg:pl-40 lg:pr-40 md:pl-15 md:pr-15 sm:pl-10 sm:pr-10 h-full min-h-screen">
    @include('partials.my-settings.settings-heading')

    <x-site-settings.layout :heading="__('Mon établissement')" class="w-full h-full">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 h-full w-full min-h-screen">
            <!-- Left column: Form -->
            <div class="space-y-6 h-full flex flex-col border border-gray-200 dark:border-gray-700 rounded-lg p-8 shadow-lg">
                <form wire:submit.prevent="{{ $isEditing ? 'updateEtablissementInformation' : '' }}" class="w-full space-y-8 flex-grow flex flex-col">
                    <flux:input
                        wire:model="nomination"
                        :label="__('Nomination')"
                        type="text"
                        required
                        autofocus
                        :placeholder="__('Nom de l\'établissement')"
                        :disabled="!$isEditing"
                    />

                    <flux:input
                        wire:model="adresse"
                        :label="__('Adresse')"
                        type="text"
                        :placeholder="__('Adresse de l\'établissement')"
                        :disabled="!$isEditing"
                    />

                    <flux:input
                        wire:model="date_creation"
                        :label="__('Date de création')"
                        type="date"
                        :placeholder="__('Date de création')"
                        :disabled="!$isEditing"
                    />

                    <flux:input
                        wire:model="nif"
                        :label="__('NIF')"
                        type="text"
                        :placeholder="__('Numéro d\'identification fiscale')"
                        :disabled="!$isEditing"
                    />

                    <flux:input
                        wire:model="stat"
                        :label="__('STAT')"
                        type="text"
                        :placeholder="__('Numéro statistique')"
                        :disabled="!$isEditing"
                    />

                    @if ($isEditing)
                        <div class="flex items-center gap-4 mt-6">
                            <div class="flex items-center justify-end space-x-3">
                                <flux:button variant="primary" type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white">{{ __('Enregistrer') }}</flux:button>
                                <flux:button wire:click.prevent="cancelEdit" variant="outline" class="w-full bg-white hover:bg-gray-50 text-red-600 border-red-300 hover:border-red-400">{{ __('Annuler') }}</flux:button>
                            </div>

                            <x-action-message class="me-3" on="profile-updated">
                                {{ __('Enregistré.') }}
                            </x-action-message>
                        </div>
                    @else
                        <div class="mt-6">
                            <flux:button
                                wire:click="toggleEditMode"
                                variant="primary"
                                icon="pencil-square"
                                class="w-full px-4 py-2"
                            >
                                {{ __('Modifier') }}
                            </flux:button>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Right column: Logo and template file name -->
            <div class="flex flex-col items-center justify-between h-full border border-gray-200 dark:border-gray-700 rounded-lg p-8 shadow-lg">
                <div class="flex flex-col items-center flex-grow py-8">
                    <livewire:mysetting.etablissement.upload-logo-form :entiteEmmeteur="$entiteEmmeteur"/>
                </div>

                {{--<!-- Template file name at the bottom -->
                <div class="w-full mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col items-center justify-center">
                        <p class="text-xs text-gray-500 dark:text-gray-400 text-center mb-3">
                            {{ __('Fichier de modèle') }}: mon-etablissement.blade.php
                        </p>
                        <flux:button
                            wire:click="$dispatch('openModal', { component: 'template-editor' })"
                            variant="outline"
                            icon="document-text"
                            size="xs"
                            class="px-2 py-1 text-xs"
                        >
                            {{ __('Modifier le modèle') }}
                        </flux:button>
                    </div>
                </div>--}}
            </div>
        </div>
    </x-site-settings.layout>
</section>
