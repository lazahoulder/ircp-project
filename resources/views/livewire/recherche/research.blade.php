<section class="bg-gradient-to-br from-grey-950 to-blue-900 text-white py-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto text-center">
        <h1 class="text-3xl sm:text-5xl font-bold mb-6">Recherchez votre certificat</h1>
        <p class="text-lg sm:text-xl mb-8 text-green-100">
            Entrez votre nom ou numéro de certificat pour vérifier son authenticité.
        </p>

        <div class="max-w-2xl mx-auto">
            <div class="flex items-center bg-white dark:bg-neutral-800 rounded-full shadow-lg overflow-hidden ring-1 ring-neutral-300 dark:ring-neutral-700">
                <input
                    type="text"
                    wire:model.debounce.500ms="q"
                    placeholder="Rechercher un certificat..."
                    class="w-full px-4 py-2 rounded-lg shadow-md bg-neutral-800 text-white placeholder-gray-400 focus:outline-none focus:ring focus:border-blue-500"
                />
                <button type="button" wire:click="$dispatch('upda')" class="px-6 py-3 bg-blue-800 hover:bg-blue-950 text-white font-semibold transition">
                    Rechercher
                </button>
            </div>
        </div>
    </div>
</section>
