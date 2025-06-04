<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.site-partials.myapp-head')

</head>
<body class="dark:bg-dark-900">
@include('partials.site-partials.header')

<main>
    {{ $slot }}
</main>

@include('partials.site-partials.footer')

@if (Route::has('login'))
    <div class="h-14.5 hidden lg:block"></div>
@endif
</body>
</html>
