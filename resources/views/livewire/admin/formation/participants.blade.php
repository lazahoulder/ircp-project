<?php

use App\Services\CertificateService;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\On;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public ?int $formationReelId = null;
    public string $querySearch = '';
    private CertificateService $certificateService;

    public function boot(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    #[On('open-search')]
    public function openSearch($id)
    {
        $this->formationReelId = $id;
        Flux::modal('show-participants')->show();
    }

    public function closeModalParticipants()
    {
        Flux::modal('show-participants')->close();
    }

    public function search()
    {
        $this->resetPage();
    }

    public function searchCertificate()
    {
        $this->search();
    }

    public function render(): mixed
    {
        $participants = $this->formationReelId ? $this
            ->certificateService
            ->searchCertificateByEntity(
                $this->querySearch,
                $this->formationReelId) : new LengthAwarePaginator([], 0, 10);

        return view('livewire.admin.formation.participants', [
            'participants' => $participants,
        ]);
    }

}; ?>

<div class="w-full px-4 sm:px-6 lg:px-8 py-8 mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <!-- Certificate Header -->
        <div class="bg-gradient-to-r from-blue-900 to-indigo-900 px-4 sm:px-6 py-4">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div
                    class="flex items-center bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:shadow-green-500/10 border border-gray-200 dark:border-gray-700 flex-1 max-w-7xl">
                    <div class="flex-grow flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-4 text-gray-400" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input
                            type="text"
                            wire:model="querySearch"
                            wire:keydown.enter="searchCertificate"
                            placeholder="Rechercher des participants..."
                            class="flex-grow px-3 py-2 text-sm text-gray-800 dark:text-white bg-transparent placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-0"
                        >
                    </div>
                    <button
                        type="button"
                        wire:click="searchCertificate"
                        class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium text-sm transition-all duration-300"
                    >
                        Rechercher
                    </button>
                </div>
                <a
                    href="{{ route('admin.certificates.export', $formationReelId) }}"
                    target="_blank"
                    title="Télécharger la liste"
                    class="px-3 sm:px-4 py-2 bg-white text-blue-600 rounded-md shadow-sm hover:bg-blue-50 transition-colors duration-150 flex items-center justify-center whitespace-nowrap"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-sm sm:text-base">Télécharger la liste</span>
                </a>
            </div>
        </div>

        <!-- Certificate Content -->
        <div class="">
            <div class="gap-8">
                <x-participant-list :participants="$participants"></x-participant-list>
            </div>

        </div>

        <!-- Certificate Footer -->
        <div
            class="bg-gray-50 dark:bg-gray-900 px-4 sm:px-6 py-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="text-sm text-gray-500 dark:text-gray-400 text-center sm:text-left">
                Ce certificat est vérifiable en ligne.
            </div>
            <button
                wire:click="closeModalParticipants"
                class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md shadow-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150 w-full sm:w-auto"
            >
                Fermer
            </button>
        </div>
    </div>
</div>
