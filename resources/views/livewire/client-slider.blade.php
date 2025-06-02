<div class="w-full">
    <div class="text-center mb-10">
        <h2 class="text-2xl font-bold text-white">🏢 Nos Centres Accrédités</h2>
        <p class="mt-2 text-white text-lg">
            Découvrez nos centres accrédités par l'IRCP Madagascar
        </p>
    </div>

    <!-- Centers Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        @foreach($clients as $client)
            <div class="bg-white dark:bg-gray-700 rounded-xl shadow-md overflow-hidden hover:shadow-lg hover:scale-105 hover:bg-blue-50 dark:hover:bg-gray-600 transition-all duration-300 h-full">
                <div class="p-4">
                    <!-- Logo/Image -->
                    <div class="flex justify-center mb-4">
                        @if($client->image && $client->image->file_path)
                            <img src="{{ asset($client->image->file_path) }}" alt="{{ $client->nomination }}" class="h-24 w-24 object-contain rounded-lg">
                        @else
                            <div class="h-24 w-24 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Center Information -->
                    <div class="text-center mb-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $client->nomination }}</h3>
                    </div>

                    <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $client->adresse }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- See More Button -->
    <div class="text-center mt-6">
        <a href="{{ route('centres') }}" class="inline-flex items-center justify-center px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-lg font-semibold shadow transition">
            Voir tous les centres
            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
        </a>
    </div>
</div>
