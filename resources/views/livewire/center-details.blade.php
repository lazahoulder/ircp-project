<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    @include('partials.site-partials.breadcrumb', ['breadcrumbs' => [
        ['label' => 'Centres Accrédités', 'url' => route('centres')],
        ['label' => $center->nomination, 'url' => route('centre.details', $center->id)]
    ]])

    <!-- Hero Section with Center Details -->
    <section class="bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 text-white py-16 px-4 sm:px-6 lg:px-8 shadow-xl">
        <div class="max-w-5xl mx-auto">
            <div class="flex items-center mb-6">
                <a href="{{ route('centres') }}" class="flex items-center text-blue-200 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour à la liste des centres
                </a>
            </div>

            <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                <!-- Center Logo -->
                <div class="flex-shrink-0">
                    @if($center->image && $center->image->file_path)
                        <img src="{{ asset($center->image->file_path) }}" alt="{{ $center->nomination }}" class="h-48 w-48 object-contain bg-white rounded-xl p-2">
                    @else
                        <div class="h-48 w-48 bg-gray-200 dark:bg-gray-600 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Center Information -->
                <div class="flex-grow text-center md:text-left">
                    <h1 class="text-4xl sm:text-5xl font-extrabold mb-4 tracking-tight">
                        {{ $center->nomination }}
                    </h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-lg text-blue-100">
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-300 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $center->adresse }}</span>
                        </div>

                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Créé le: {{ $center->date_creation }}</span>
                        </div>

                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>NIF: {{ $center->nif }}</span>
                        </div>

                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-300 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                            <span>STAT: {{ $center->stat }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Formations Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <!-- Section Header -->
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Formations proposées</h2>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    {{ count($formations) }} formation(s) disponible(s)
                </div>
            </div>

            <!-- Formations List -->
            <div class="p-6">
                @if(count($formations) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($formations as $formation)
                            <div class="bg-white dark:bg-gray-700 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $formation->titre }}</h3>

                                    <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">{{ $formation->description }}</p>

                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Expiration: {{ $formation->expiration_year }} an(s)</span>
                                    </div>

                                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sessions de formation:</h4>

                                        @if(count($formation->formationReels) > 0)
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                @foreach($formation->formationReels as $session)
                                                    <div class="text-sm bg-gray-50 dark:bg-gray-800 rounded-lg p-2">
                                                        <div class="flex justify-between">
                                                            <span class="text-gray-600 dark:text-gray-400">Du {{ $session->date_debut }}</span>
                                                            <span class="text-gray-600 dark:text-gray-400">Au {{ $session->date_fin }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500 dark:text-gray-400 italic">Aucune session programmée</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-xl font-medium text-gray-500 dark:text-gray-400">Aucune formation disponible</p>
                        <p class="text-base mt-2 text-gray-500 dark:text-gray-400">Ce centre n'a pas encore de formations enregistrées</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
