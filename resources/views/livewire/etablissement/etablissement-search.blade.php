<?php

use App\Constant\EntiteEmmeteursConstant;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.app')] class extends Component {

    public string $query = '';

    #[\Livewire\Attributes\Url]
    public string $status = '';

    public array $statusEtab = [];

    public function boot()
    {
        $this->statusEtab[] = EntiteEmmeteursConstant::STATUS_EN_ATTENTE;
        $this->statusEtab[] = EntiteEmmeteursConstant::STATUS_INCOMPLET;
        $this->statusEtab[] = EntiteEmmeteursConstant::STATUS_VALID;
    }

    public function search(): void
    {
        $this->dispatch('launch-search', query: $this->query, status: $this->status);
    }

}; ?>

<div class="flex space-x-2 items-stretch">

    <!-- Groupe Recherche + Bouton Rechercher -->
    <div class="flex flex-1 items-stretch rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-md">
        <div class="flex items-center px-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <input
            type="text"
            wire:model.debounce.500ms="query"
            wire:keydown.enter="search"
            placeholder="Nom du centre ou adresse..."
            class="flex-grow px-3 py-2 text-sm text-gray-800 dark:text-white bg-transparent placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-0"
        />
        <button
            type="button"
            wire:click="search"
            class="px-4 bg-green-500 hover:bg-green-600 text-white text-sm font-medium transition-all duration-300"
        >
            Rechercher
        </button>
    </div>

    <!-- Sélecteur de statut -->
    <div class="w-64">
        <flux:select
            wire:model="status"
            placeholder="Statut"
            wire:change="search"
            class="w-full h-full px-3 py-2 text-sm text-gray-800 dark:text-white bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg focus:outline-none"
        >
            <flux:select.option value="">Statut de l'établissement</flux:select.option>
            @foreach($statusEtab as $etat)
                <flux:select.option value="{{ $etat }}">{{ $etat }}</flux:select.option>
            @endforeach
        </flux:select>
    </div>

</div>

