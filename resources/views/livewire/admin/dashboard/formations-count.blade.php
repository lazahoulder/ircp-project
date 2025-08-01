<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<section class="min-w-full">
    <h5 class="text-xl font-semibold mb-6 text-center">Les Formations</h5>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
        <div class="flex items-center gap-4 p-4 rounded-xl bg-indigo-50 dark:bg-indigo-900 text-indigo-900 dark:text-indigo-100 shadow">
            <flux:icon name="academic-cap" class="h-8 w-8 text-indigo-600 dark:text-indigo-300" />
            <div>
                <div class="text-sm font-medium text-indigo-800 dark:text-indigo-200">Formations ajoutées</div>
                <div class="text-xl font-semibold">18</div>
            </div>
        </div>

        <div class="flex items-center gap-4 p-4 rounded-xl bg-green-600 text-white shadow hover:opacity-90 transition col-span-full lg:col-span-1">
            <flux:icon name="eye" class="h-8 w-8 text-green-300" />
            <div>
                <div class="text-sm font-medium ">Formations publié</div>
                <div class="text-xl font-semibold">22</div>
            </div>
        </div>

        <div class="flex items-center gap-4 p-4 rounded-xl bg-purple-50 dark:bg-purple-900 text-purple-900 dark:text-purple-100 shadow">
            <flux:icon name="sparkles" class="h-8 w-8 text-purple-600 dark:text-purple-300" />
            <div>
                <div class="text-sm font-medium text-purple-800 dark:text-purple-200">Réalisation de formation ajouté</div>
                <div class="text-xl font-semibold">22</div>
            </div>
        </div>
        <div class="flex items-center gap-4 p-4 rounded-xl bg-yellow-600 text-white shadow hover:opacity-90 transition">
            <flux:icon name="exclamation-circle" class="h-8 w-8 text-yellow-300" />
            <div>
                <div class="text-sm font-medium">Réalisation en attente</div>
                <div class="text-2xl font-bold">14</div>
            </div>
        </div>
    </div>
</section>
