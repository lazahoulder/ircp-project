<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<script>
    // Force dark theme regardless of system preference or localStorage
    document.documentElement.classList.add('dark');
    document.documentElement.classList.remove('light');

    // Set localStorage to dark theme
    localStorage.setItem('hs_theme', 'dark');

    // Override any attempts to change the theme
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                if (!document.documentElement.classList.contains('dark') || document.documentElement.classList.contains('light')) {
                    document.documentElement.classList.add('dark');
                    document.documentElement.classList.remove('light');
                }
            }
        });
    });

    observer.observe(document.documentElement, { attributes: true });

    // Ensure dark theme is applied even after page load
    window.addEventListener('DOMContentLoaded', function() {
        document.documentElement.classList.add('dark');
        document.documentElement.classList.remove('light');
    });
</script>

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
