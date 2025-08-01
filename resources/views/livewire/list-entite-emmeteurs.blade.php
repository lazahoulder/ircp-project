<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    @if ($hasSearch)
    <!-- Hero Section with Search -->
    <section class="bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 text-white py-16 px-4 sm:px-6 lg:px-8 shadow-xl">
        <div class="max-w-5xl mx-auto text-center">
            <h1 class="text-4xl sm:text-6xl font-extrabold mb-6 tracking-tight">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-green-300">
                    Centres Accrédités
                </span>
            </h1>
            <p class="text-xl sm:text-2xl mb-10 text-blue-100 max-w-3xl mx-auto leading-relaxed">
                Recherchez un centre accrédité par son nom ou son adresse
            </p>

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
                            class="flex-grow px-4 py-4 text-gray-800 dark:text-white bg-transparent placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-0 text-lg"
                        />
                    </div>
                    <button type="button"
                            wire:click="search"
                            class="px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold transition-all duration-300 text-lg">
                        Rechercher
                    </button>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Results Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Centres Accrédités</h2>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Liste des centres accrédités
                </div>
            </div>

            <!-- Grid Layout -->
            <div class="p-6">
                @if(count($entiteEmmeteurs) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($entiteEmmeteurs as $entite)
                            <a href="{{ route('centre.details', $entite->id) }}" class="block" wire:navigate>
                                <div class="bg-white dark:bg-gray-700 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 cursor-pointer">
                                    <div class="p-4">
                                        <!-- Logo/Image -->
                                        <div class="flex justify-center mb-4">
                                            @if($entite->image && $entite->image->file_path)
                                                <img src="{{ asset('/storage/'.$entite->image->file_path) }}" alt="{{ $entite->nomination }}" class="h-32 w-32 object-contain rounded-lg">
                                            @else
                                                <div class="h-32 w-32 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Center Information -->
                                        <div class="text-center mb-2">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $entite->nomination }}</h3>
                                        </div>

                                        <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                                            <div class="flex items-start">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span>{{ $entite->adresse }}</span>
                                            </div>

                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>Créé le: {{ $entite->date_creation }}</span>
                                            </div>

                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <span>NIF: {{ $entite->nif }}</span>
                                            </div>

                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                                </svg>
                                                <span>STAT: {{ $entite->stat }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-xl font-medium text-gray-500 dark:text-gray-400">Aucun centre trouvé</p>
                        <p class="text-base mt-2 text-gray-500 dark:text-gray-400">Essayez avec un autre terme de recherche</p>
                    </div>
                @endif
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                {{ $entiteEmmeteurs->links() }}
            </div>
        </div>
    </div>
</div>
