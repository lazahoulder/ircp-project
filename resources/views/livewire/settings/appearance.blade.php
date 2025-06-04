<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.app')] class extends Component {
    //
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Appearance')" :subheading=" __('Theme settings for your account')">
        <div class="flex items-center gap-2">
            <flux:icon name="moon" class="h-5 w-5" />
            <p>{{ __('Dark theme is enabled') }}</p>
        </div>
    </x-settings.layout>
</section>
