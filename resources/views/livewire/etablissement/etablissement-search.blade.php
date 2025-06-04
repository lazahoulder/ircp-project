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

<div>
    <div class="max-w-3xl mx-auto relative">
        <div class="flex items-center bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden transition-all duration-300 hover:shadow-green-500/10 border border-gray-200 dark:border-gray-700">
            <div class="flex-grow flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input
                    type="text"
                    wire:model.debounce.500ms="query"
                    wire:keydown.enter="search"
                    placeholder="Nom du centre ou adresse..."
                    class="flex-grow px-4 py-4 text-gray-800 dark:text-white bg-transparent placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-0"
                />
            </div>
            <button type="button"
                    wire:click="search"
                    class="px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold transition-all duration-300">
                Rechercher
            </button>
        </div>
    </div>
</div>
