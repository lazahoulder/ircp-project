<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-gray-950 dark:to-gray-900 dark-variant:bg-neutral-900 light-variant:bg-zinc-50">
<div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
    <div class="bg-muted relative hidden h-full flex-col p-10 text-white lg:flex dark:border-e dark:border-gray-800 dark-variant:border-neutral-700 light-variant:border-zinc-200 light-variant:bg-blue-600">
        <div class="absolute inset-0 bg-gray-950 bg-no-repeat bg-cover z-0"
             style="background-image: url('{{ asset('images/certificate-bg.png') }}');"></div>

        <!-- Overlay sombre pour lisibilité -->
        <div class="absolute inset-0 bg-gray-950 md:bg-gray-950/50 z-0 backdrop-blur-md dark-variant:bg-indigo-950/70 light-variant:bg-blue-700/70"></div>
        <div class="items-center justify-center">
            <a href="{{ route('home') }}" class="relative z-20 flex items-center justify-center text-lg font-medium" wire:navigate>
                <img src="{{ asset('logo/ircp-madagascar-logo.svg') }}" alt="">
            </a>
        </div>

        @php
            [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
        @endphp

        <div class="relative z-20 mt-auto">
            <blockquote class="space-y-2">
                <flux:heading size="lg">&ldquo;{{ trim($message) }}&rdquo;</flux:heading>
                <footer>
                    <flux:heading>{{ trim($author) }}</flux:heading>
                </footer>
            </blockquote>
        </div>
    </div>
    <div class="w-full lg:p-8">
        <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
            <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden"
               wire:navigate>
                        <span class="flex h-9 w-9 items-center justify-center rounded-md">
                            <x-app-logo-icon class="size-9 fill-current text-black dark:text-white light-variant:text-blue-600"/>
                        </span>

                <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
            </a>
            {{ $slot }}
        </div>
    </div>
</div>
@fluxScripts
</body>
</html>
