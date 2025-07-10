@php use App\Constant\EntiteEmmeteursConstant; @endphp
<div>
    <x-settings.admin heading="Gestion des établissements" subheading="Detail d'un etablissement"/>

    <flux:modal name="edit-center" focusable class="max-w-2xl" variant="flyout">
        <livewire:admin.etablissement.form-etablissemet :center="$center"/>
    </flux:modal>

    <div class="min-h-screen">
        <!-- Hero Section with Center Details -->
        <section class="py-5 px-4 sm:px-5 lg:px-5 shadow-xl">
            <div class="max-w-5xl mx-auto">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin.etablissements') }}"
                           class="flex items-center text-blue-200 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Retour à la liste des centres
                        </a>
                    </div>
                    <div class="flex-grow text-right">
                        <flux:modal.trigger name="edit-center">
                            <flux:button
                                variant="outline"
                                icon="pencil"
                                size="sm"
                                class="px-3 py-1.5 text-sm"
                                tooltip="Modifier le centre"
                            >
                            </flux:button>
                        </flux:modal.trigger>
                        @if ($center->status == EntiteEmmeteursConstant::STATUS_INCOMPLET)
                            <flux:button size="sm" tooltip="Valider le centre"
                                         href="{{ route('admin.etablissements-details', $center->id) }}"
                                         variant="outline" icon="check" class="text-blue-600 hover:text-green-800">
                            </flux:button>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                    <!-- Center Logo -->
                    <div class="flex-shrink-0">
                        <livewire:mysetting.etablissement.upload-logo-form :entiteEmmeteur="$center"/>
                    </div>

                    <!-- Center Information -->
                    <div class="flex-grow text-center md:text-left">
                        <h1 class="text-4xl sm:text-5xl font-extrabold mb-4 tracking-tight">
                            {{ $center->nomination }}
                        </h1>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-lg text-blue-100">
                            <div class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-300 mr-2 mt-0.5"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="{{ $center->adresse || $center->adresse != ''  ? "" : "text-red-400" }}">
                                    {{ $center->adresse || $center->adresse != '' ? $center->adresse : "A completer!" }}
                                </span>
                            </div>

                            <div class="flex items-center ">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-300 mr-2" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Créé le : &nbsp;
                                <span class="{{ $center->date_creation ? "" : "text-red-400" }}">
                                    {{ $center->date_creation ?? "A completer!" }}
                                </span>
                            </div>

                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-300 mr-2" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                NIF : &nbsp;
                                <span class="{{ $center->nif || $center->nif != '' ? "" : "text-red-400" }}">
                                    {{ $center->nif || $center->nif != '' ? $center->nif : "A completer!" }}
                                </span>
                            </div>

                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-300 mr-2" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                                STAT : &nbsp;
                                <span class="{{ $center->stat || $center->stat != '' ? "" : "text-red-400" }}">
                                    {{ $center->stat || $center->stat != '' ? $center->stat : "A completer!" }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Formations Section -->
        <div class="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <livewire:admin.formation.list-formation :centre="$center"/>
        </div>
    </div>
</div>
