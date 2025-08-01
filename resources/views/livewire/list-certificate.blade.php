<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Hero Section with Search -->
    <section
        class="bg-gradient-to-br from-blue-900 via-indigo-800 to-purple-900 text-white py-16 px-4 sm:px-6 lg:px-8 shadow-xl">
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
                <div
                    class="flex items-center bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden transition-all duration-300 hover:shadow-green-500/10 border border-gray-200 dark:border-gray-700">
                    <div class="flex-grow flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-4 text-gray-400" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input
                            type="text"
                            wire:model.live="query"
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
        <x-certificate :certificates="$certificates" />
    </div>
</div>
