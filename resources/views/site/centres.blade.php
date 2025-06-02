<x-layouts.site.app :title="__('Centres Accrédités - IRCP')">
    @include('partials.site-partials.breadcrumb', ['breadcrumbs' => [
        ['label' => 'Centres Accrédités', 'url' => route('centres')]
    ]])

    <livewire:list-entite-emmeteurs />
</x-layouts.site.app>
