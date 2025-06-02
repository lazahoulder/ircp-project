<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Hero Section with Search -->
    <section class="bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 text-white py-16 px-4 sm:px-6 lg:px-8 shadow-xl">
        <div class="max-w-5xl mx-auto text-center">
            <h1 class="text-4xl sm:text-6xl font-extrabold mb-6 tracking-tight">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-green-300">
                    Recherchez votre certificat
                </span>
            </h1>
            <p class="text-xl sm:text-2xl mb-10 text-blue-100 max-w-3xl mx-auto leading-relaxed">
                Entrez votre nom ou numéro de certificat pour vérifier son authenticité.
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
                            placeholder="Nom, prénom, ou numéro de certificat..."
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

    <!-- Results Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Résultats de la recherche</h2>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Cliquez sur un certificat pour voir les détails
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                N° Certificat
                            </th>
                            <th scope="col" class="hidden md:table-cell px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Titre de la formation
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Nom
                            </th>
                            <th scope="col" class="hidden sm:table-cell px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Prénom
                            </th>
                            <th scope="col" class="hidden lg:table-cell px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Établissement
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($certificates as $certificat)
                            <tr
                                class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150 ease-in-out"
                            >
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 overflow-hidden rounded-full">
                                            @if($certificat->personneCertifies && $certificat->personneCertifies->image && $certificat->personneCertifies->image->file_path)
                                                <img src="{{ asset($certificat->personneCertifies->image->file_path) }}" alt="{{ $certificat->personneCertifies->nom }}" class="h-10 w-10 object-cover">
                                            @else
                                                <div class="h-10 w-10 flex items-center justify-center bg-green-100 dark:bg-green-900 rounded-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $certificat->numero_certificat }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden md:table-cell px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $certificat->formationReel->formation->titre }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $certificat->nom }}</div>
                                </td>
                                <td class="hidden sm:table-cell px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $certificat->prenom }}</div>
                                </td>
                                <td class="hidden lg:table-cell px-6 py-4">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $certificat->getEntiteEmmeteurs()->nomination }}</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button
                                        wire:click="$dispatch('showCertificatInModal', { id: {{ $certificat->id }} })"
                                        class="px-3 py-1 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 transition-colors duration-150 text-xs flex items-center"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Détails
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                        @if(count($certificates) === 0)
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-lg font-medium">Aucun certificat trouvé</p>
                                        <p class="text-sm mt-1">Essayez avec un autre terme de recherche</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                {{ $certificates->links() }}
            </div>
        </div>
    </div>

    <!-- Modal for Certificate Details -->
    <flux:modal name="show-certificate" class="max-w-4xl md:max-w-5xl lg:max-w-6xl xl:max-w-7xl mx-auto">
        <livewire:certificate-details/>
    </flux:modal>
</div>
