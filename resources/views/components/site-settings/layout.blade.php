<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <flux:navlist>
            <flux:navlist.item :href="route('moncompte.etablissement')" icon="building" wire:navigate>{{ __('Mon etablissement') }}</flux:navlist.item>
            <flux:navlist.item :href="route('moncompte.formations')" icon="book-type" wire:navigate>{{ __('Mes formations') }}</flux:navlist.item>
            <flux:navlist.item :href="route('moncompte.profile')" icon="user" wire:navigate>{{ __('Profile') }}</flux:navlist.item>
            <flux:navlist.item :href="route('moncompte.password')" icon="cog" wire:navigate>{{ __('Password') }}</flux:navlist.item>
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div class="mt-5 w-full max-w-5lg">
            {{ $slot }}
        </div>
    </div>
</div>
