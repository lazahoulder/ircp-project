<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.app')] class extends Component {

    public string $modalName = "create-center";

}; ?>

<div>
    <x-settings.admin heading="Gestion des établissements" subheading="Liste des établissements"/>
    <div class="max-w-7xl mx-auto relative px-10">
        <div class="flex items-center gap-4">
            <!-- Barre de recherche -->
            <div class="flex-1">
                <livewire:etablissement.etablissement-search />
            </div>
            <!-- Bouton Nouveau -->
            <flux:modal.trigger name="create-center">
                <button
                    type="button"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-all duration-300 flex items-center gap-2"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nouveau
                </button>
            </flux:modal.trigger>
        </div>

    </div>
    <div class="px-10 py-5">
        <livewire:admin.liste-etablissement has-search="listHasSearch" />
    </div>

    <flux:modal name="create-center" focusable class="max-w-2xl" variant="flyout">
        <livewire:admin.etablissement.form-etablissemet :modalName="$modalName" />
    </flux:modal>
</div>
