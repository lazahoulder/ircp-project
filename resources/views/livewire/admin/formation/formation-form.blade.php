<div class="space-y-6 h-full flex flex-col border border-gray-200 dark:border-gray-700 rounded-lg p-8 shadow-lg">
    <h4>
        Saisissez les informations
    </h4>
    <form wire:submit.prevent="storeFormation" class="space-y-4">
        @if(is_null($entite_emmeteur_id))
            <flux:select
                wire:model="entite_emmeteur_id"
                :label="__('Centre de formation')"
                required
                autofocus
                :placeholder="__('Centre de formation')"
            >
                @foreach($entityChoices as $entity)
                    <flux:select.option value="{{ $entity['id'] }}">{{ $entity['nomination'] }}</flux:select.option>
                @endforeach
            </flux:select>
        @endif
        <flux:input
            wire:model="titre"
            :label="__('Titre')"
            type="text"
            required
            autofocus
            :placeholder="__('Titre de la formation')"
        />

        <flux:input
            wire:model="description"
            :label="__('Description')"
            type="text"
            required
            :placeholder="__('Description de la formation')"
        />

        <flux:input
            wire:model="expiration_year"
            :label="__('Année d\'expiration (optionnel)')"
            type="number"
            min="0"
            :placeholder="__('Nombre d\'années avant expiration')"
        />


        @if($errorMessage)
            <div class="mt-4 p-4 bg-red-50 border border-red-200 rounded-md text-red-600">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">{{ __('Erreur de validation') }}</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <p>{{ $errorMessage }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex items-center gap-4 mt-6">
            <div class="flex items-center justify-end space-x-3">
                <flux:button type="submit" variant="primary"
                             class="w-full bg-green-600 hover:bg-green-700 text-white">
                    {{  __('Enregistrer') }}
                </flux:button>
                <flux:button wire:click="cancelEdit" variant="outline"
                             class="w-full bg-white hover:bg-gray-50 text-red-600 border-red-300 hover:border-red-400">
                    {{ __('Annuler') }}
                </flux:button>
            </div>

            <x-action-message class="me-3" on="formation-created">
                {{ __('Formation créée.') }}
            </x-action-message>
            <x-action-message class="me-3" on="formation-updated">
                {{ __('Formation mise à jour.') }}
            </x-action-message>
        </div>
    </form>
</div>
