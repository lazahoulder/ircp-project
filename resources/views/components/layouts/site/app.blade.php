<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-white dark:bg-gray-950/80">
@include('partials.site-partials.header')

    {{ $slot }}

@include('partials.site-partials.footer')

@fluxScripts
</body>
</html>
