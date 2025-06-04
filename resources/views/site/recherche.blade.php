<x-layouts.site.app :title="__('IRCP')">
    @include('partials.site-partials.breadcrumb', ['breadcrumbs' => [
        ['label' => 'Recherche de certificat', 'url' => route('search')]
    ]])

    <livewire:list-certificate />
</x-layouts.site.app>
