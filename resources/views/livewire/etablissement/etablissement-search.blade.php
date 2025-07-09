<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.app')] class extends Component {

    public string $query = '';

    public function search(): void
    {
        $this->dispatch('launch-search', query: $this->query);
    }

}; ?>

<div class="flex items-center bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-green-500/10 border border-gray-200 dark:border-gray-700">
    <div class="flex-grow flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
        <input
            type="text"
            wire:model.debounce.500ms="query"
            wire:keydown.enter="search"
            placeholder="Nom du centre ou adresse..."
            class="flex-grow px-3 py-2 text-sm text-gray-800 dark:text-white bg-transparent placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-0"
        />
    </div>
    <button
        type="button"
        wire:click="search"
        class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium text-sm transition-all duration-300"
    >
        Rechercher
    </button>
</div>
