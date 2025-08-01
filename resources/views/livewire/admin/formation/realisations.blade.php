<?php

use App\Models\Formation;
use App\Services\FormationReelService;
use Livewire\Volt\Component;

new class extends Component {
    //
    public Formation $formation;

    public $formationReels;
    protected FormationReelService $formationReelService;

    public function boot(FormationReelService $formationReelService)
    {
        $this->formationReelService = $formationReelService;
    }
}; ?>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Réalisations de la formation: {{ $formation->titre }}</h2>
        <div class="flex space-x-2">
            <flux:button
                wire:click="$dispatch('openAddRealizationModal', { formationId: {{ $formation->id }} })"
                variant="primary" icon="plus" class="bg-green-600 hover:bg-green-700 text-white">
                {{ __('Nouvelle Réalisation') }}
            </flux:button>
            <flux:button wire:click="$set('showFormationReels', false)" variant="outline" icon="arrow-left"
                         class="text-gray-600">
                {{ __('Retour') }}
            </flux:button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Date de début
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Date de fin
                </th>
                <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                    Participants
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
            @forelse($formation->formationReels as $formationReel)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        {{ $formationReel->date_debut }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                        {{ $formationReel->date_fin }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">

                        {{--<a href="{{ route('admin.certificates.export', $formationReel->id) }}" target="_blank"
                           class="text-blue-600 hover:underline flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                            </svg>
                            {{ __('Télécharger') }}
                        </a>--}}
                        <flux:button size="sm" wire:click="$dispatch('open-search', { id: {{ $formationReel->id }} })"
                                     variant="primary" icon="eye"
                                     class="bg-blue-600 hover:bg-blue-700 text-white">
                            {{ __('Voir') }}
                        </flux:button>
                        <flux:button size="sm" wire:click="regenerateQrCode({{ $formationReel->id }})"
                                     variant="primary" icon="qr-code"
                                     class="bg-blue-600 hover:bg-blue-700 text-white">
                            {{ __('Regenerer QR-CODE') }}
                        </flux:button>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4"
                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300 text-center">
                        Aucune réalisation pour cette formation
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal for adding a new realization -->
    <flux:modal name="add-realization-modal" class="max-w-2xl">
        <livewire:formation.add-formation-realization/>
    </flux:modal>

    <flux:modal name="show-participants" class="max-w-4xl md:max-w-5xl lg:max-w-6xl xl:max-w-7xl mx-auto">
        <livewire:admin.formation.participants/>
    </flux:modal>
</div>
