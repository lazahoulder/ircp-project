<div class="space-y-6 h-full flex flex-col border border-gray-200 dark:border-gray-700 rounded-lg p-8 shadow-lg">
    <h4>
        @if ($isEditing)
            Modifier
        @else
            Creation
        @endif
    </h4>
    <form wire:submit.prevent="saveEtab" class="w-full space-y-8 flex-grow flex flex-col">
        <flux:input
            wire:model="nomination"
            :label="__('Nomination')"
            type="text"
            required
            autofocus
            :placeholder="__('Nom de l\'établissement')"
        />

        <flux:input
            wire:model="adresse"
            :label="__('Adresse')"
            type="text"
            :placeholder="__('Adresse de l\'établissement')"
        />

        <flux:input
            wire:model="date_creation"
            :label="__('Date de création')"
            type="date"
            :placeholder="__('Date de création')"
        />

        <flux:input
            wire:model="nif"
            :label="__('NIF')"
            type="text"
            :placeholder="__('Numéro d\'identification fiscale')"
        />

        <flux:input
            wire:model="stat"
            :label="__('STAT')"
            type="text"
            :placeholder="__('Numéro statistique')"
        />


        <div class="flex items-center gap-4 mt-6">
            <div class="flex items-center justify-end space-x-3">
                <flux:button variant="primary" type="submit"
                             class="w-full bg-green-600 hover:bg-green-700 text-white">{{ __('Enregistrer') }}</flux:button>
                <flux:button wire:click.prevent="cancelEdit" variant="outline"
                             class="w-full bg-white hover:bg-gray-50 text-red-600 border-red-300 hover:border-red-400">{{ __('Annuler') }}</flux:button>
            </div>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Enregistré.') }}
            </x-action-message>
        </div>

    </form>
</div>
