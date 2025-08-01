<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    <x-settings.admin heading="Les certificats" subheading="Liste des certficats"/>
    <div class="max-w-9xl mx-auto relative px-10">
        <div wire:loading.class="opacity-50" wire:loading.class.remove="opacity-100" class="opacity-100 transition-opacity" wire:target="doSearch">
            <livewire:admin.certificate.search-form />
        </div>

    </div>
    <!-- Apply loading effect to participant list -->
    <div wire:loading.class="opacity-50" wire:loading.class.remove="opacity-100" class="opacity-100 transition-opacity" wire:target="doSearch">
        <x-participant-list :participants="$certificates" :isStandAlone="$isStandAlone"></x-participant-list>
    </div>
    <!-- Optional: Separate loading indicator for pagination -->
    <div wire:loading wire:target="gotoPage,previousPage,nextPage" class="flex items-center justify-center py-4">
        <svg class="animate-spin h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="ml-2 text-gray-700">Chargement...</span>
    </div>
</div>
