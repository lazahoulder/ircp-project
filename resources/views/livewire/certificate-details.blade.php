<div class="w-full px-4 sm:px-6 lg:px-8 py-8 mx-auto">
    @if($certificate)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <!-- Certificate Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-4 sm:px-6 py-4">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                    <h2 class="text-lg sm:text-xl font-bold text-white break-words">Certificat N° {{ $certificate->numero_certificat }}</h2>
                    <a
                        href="{{ route('certificate.download', ['id' => $certificate->id]) }}"
                        target="_blank"
                        title="Télécharger le certificat au format Word"
                        class="px-3 sm:px-4 py-2 bg-white text-blue-600 rounded-md shadow-sm hover:bg-blue-50 transition-colors duration-150 flex items-center justify-center whitespace-nowrap"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="text-sm sm:text-base">Télécharger</span>
                    </a>
                </div>
            </div>

            <!-- Certificate Content -->
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div>
                        <div class="mb-6 flex items-center">
                            <!-- Photo du titulaire -->
                            <div class="mr-4">
                                @if($certificate->personneCertifies && $certificate->personneCertifies->image && $certificate->personneCertifies->image->file_path)
                                    <img src="{{ asset($certificate->personneCertifies->image->file_path) }}"
                                         alt="{{ $certificate->personneCertifies->nom }}"
                                         class="h-20 w-20 object-cover rounded-full border-2 border-blue-500">
                                @else
                                    <div class="h-20 w-20 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Titulaire du certificat</h3>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $certificate->personneCertifies->prenom }} {{ $certificate->personneCertifies->nom }}</p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Date de certification</h3>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($certificate->date_certification)->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Formation</h3>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $certificate->formationReel->formation->titre }}</p>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Établissement émetteur</h3>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $certificate->getEntiteEmmeteurs()->nomination }}</p>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Informations complémentaires</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400">Période de formation</h4>
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                Du {{ \Carbon\Carbon::parse($certificate->formationReel->date_debut)->format('d/m/Y') }}
                                au {{ \Carbon\Carbon::parse($certificate->formationReel->date_fin)->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Certificate Footer -->
            <div class="bg-gray-50 dark:bg-gray-900 px-4 sm:px-6 py-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div class="text-sm text-gray-500 dark:text-gray-400 text-center sm:text-left">
                    Ce certificat est vérifiable en ligne.
                </div>
                <button
                    wire:click="closeModal"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-md shadow-sm hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150 w-full sm:w-auto"
                >
                    Fermer
                </button>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Certificat non trouvé</h3>
            <p class="text-gray-500 dark:text-gray-400">Le certificat demandé n'existe pas ou n'est plus disponible.</p>
        </div>
    @endif
</div>
