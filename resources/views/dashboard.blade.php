<x-layouts.app :title="__('Tableau de bord')">
    <div class="flex flex-col gap-6 p-6 min-h-full">
        {{-- Titre général --}}
        <h1 class="text-3xl font-semibold  text-gray-100 mb-8 text-center">
            Tableau de bord
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 mb-10">
            <div class="flex items-center gap-4 p-4 rounded-xl shadow-md">
                <livewire:admin.dashboard.center />
            </div>
            <div class="flex items-center gap-4 p-4 rounded-xl shadow-md">
                <livewire:admin.dashboard.certificate-count />
            </div>
        </div>

        <section>
            <div class="bg-gray-800 rounded-xl p-6 shadow">
                <h2 class="text-xl font-semibold mb-4">Évolution mensuelle des certificats</h2>
                <div class="p-4">
                    <livewire:chart.formations-chart />
                </div>
            </div>
        </section>

        {{--<div x-data="{ tab: 'entites' }" class="bg-white dark:bg-neutral-900 p-6 rounded-xl border border-neutral-200 dark:border-neutral-700 shadow">
            <!-- Onglets -->
            <div class="flex space-x-4 border-b border-gray-200 dark:border-neutral-700 mb-6">
                <button @click="tab = 'entites'" :class="tab === 'entites' ? 'text-indigo-600 border-indigo-600' : 'text-gray-600 border-transparent'" class="pb-2 px-1 border-b-2 font-medium text-sm focus:outline-none">
                    Entités
                </button>
                <button @click="tab = 'formations'" :class="tab === 'formations' ? 'text-indigo-600 border-indigo-600' : 'text-gray-600 border-transparent'" class="pb-2 px-1 border-b-2 font-medium text-sm focus:outline-none">
                    Réalisations
                </button>
                <button @click="tab = 'certificats'" :class="tab === 'certificats' ? 'text-indigo-600 border-indigo-600' : 'text-gray-600 border-transparent'" class="pb-2 px-1 border-b-2 font-medium text-sm focus:outline-none">
                    Certificats
                </button>
            </div>

            <!-- Onglet Entités -->
            <div x-show="tab === 'entites'" x-transition>
                <div class="mb-4 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Liste des entités</h2>
                    <input type="text" placeholder="Filtrer..." class="px-4 py-2 border border-gray-300 dark:border-neutral-600 rounded-md bg-white dark:bg-neutral-800 text-sm text-gray-900 dark:text-gray-100" />
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm table-auto border-collapse">
                        <thead>
                        <tr class="bg-gray-100 dark:bg-neutral-800">
                            <th class="text-left px-6 py-3 font-medium text-gray-700 dark:text-gray-300">Nom</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-700 dark:text-gray-300">Statut</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-700 dark:text-gray-300">Date d'inscription</th>
                        </tr>
                        </thead>
                        <tbody>
                        --}}{{-- Exemple de ligne --}}{{--
                        <tr class="border-t border-gray-200 dark:border-neutral-700 hover:bg-gray-50 dark:hover:bg-neutral-800 cursor-pointer">
                            <td class="px-6 py-3">Groupe Ambatomena</td>
                            <td class="px-6 py-3 text-green-600 dark:text-green-400 font-semibold">Validé</td>
                            <td class="px-6 py-3">2025-07-04</td>
                        </tr>
                        <!-- ... autres lignes ici -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Onglet Réalisations -->
            <div x-show="tab === 'formations'" x-transition>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Réalisations de formations</h2>
                <div class="text-gray-700 dark:text-gray-300 text-sm">
                    <p>Aucune réalisation de formation disponible pour le moment.</p>
                    --}}{{-- Tu peux ici ajouter un tableau ou une liste comme pour "entités" --}}{{--
                </div>
            </div>

            <!-- Onglet Certificats -->
            <div x-show="tab === 'certificats'" x-transition>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Certificats délivrés</h2>
                <div class="text-gray-700 dark:text-gray-300 text-sm">
                    <p>Aucun certificat disponible.</p>
                    --}}{{-- À remplacer par un tableau ou composant selon tes besoins --}}{{--
                </div>
            </div>
        </div>--}}
    </div>
</x-layouts.app>
