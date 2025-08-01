<div>
    <h1 class="text-3xl font-semibold  text-gray-100 mb-8 text-center">
        Liste des certificats
    </h1>
    <div class="max-w-9xl mx-auto relative px-10">
        <div wire:loading.class="opacity-50" wire:loading.class.remove="opacity-100" class="opacity-100 transition-opacity" wire:target="search">
            <div class="flex w-full space-x-3 items-center">
                <!-- Groupe Recherche + Bouton Rechercher -->
                <div class="flex flex-1 items-stretch rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-md min-w-0">
                    <div class="flex items-center px-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input
                        type="text"
                        wire:model.live="query"
                        wire:keydown.enter="search"
                        placeholder="Nom du centre ou adresse..."
                        class="flex-grow px-3 py-2 text-sm text-gray-800 dark:text-white bg-transparent placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-0"
                    />
                </div>

                <!-- Sélecteur de statut -->
                <div class="flex-shrink-0 w-64">
                    <flux:select
                        wire:model.live="status"
                        class="w-full h-full px-3 py-2 text-sm text-gray-800 dark:text-white bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg focus:outline-none"
                    >
                        <flux:select.option value="">Statut du certificat</flux:select.option>
                        @foreach($statusCertificates as $etat)
                            <flux:select.option value="{{ $etat }}">{{ $etat }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>

                <!-- Sélecteur de centre de formation -->
                <div class="flex-shrink-0 w-64">
                    <flux:select
                        wire:model.live="entiteEmmeteurId"
                        class="w-full h-full px-3 py-2 text-sm text-gray-800 dark:text-white bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg focus:outline-none"
                    >
                        <flux:select.option value="">Centre de formation</flux:select.option>
                        @foreach($entityChoices as $entity)
                            <flux:select.option value="{{ $entity['id'] }}">{{ $entity['nomination'] }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>

                @if(!empty($formationChoices))
                    <div class="flex-shrink-0 w-64">
                        <flux:select
                            wire:model.live="formationId"
                            class="w-full h-full px-3 py-2 text-sm text-gray-800 dark:text-white bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg focus:outline-none"
                        >
                            <flux:select.option value="">Formation</flux:select.option>
                            @foreach($formationChoices as $formation)
                                <flux:select.option value="{{ $formation['id'] }}">{{ $formation['titre'] }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>
                @endif
            </div>
        </div>

    </div>
    <!-- Apply loading effect to participant list -->
    <div wire:loading.class="opacity-50" wire:loading.class.remove="opacity-100" class="opacity-100 transition-opacity" wire:target="search">
        <x-participant-list :participants="$certificates" :isStandAlone="$isStandAlone" :status="$status"></x-participant-list>
    </div>
    <!-- Optional: Separate loading indicator for pagination -->
</div>
