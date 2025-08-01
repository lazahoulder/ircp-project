<div class="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        <!-- Table Header -->
        <div
            class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">Résultats de la recherche</h2>
            <div class="text-sm text-gray-500 dark:text-gray-400">
                @if($status == \App\Constant\CertificateConstant::STATUS_EN_ATTENTE && count($participants) > 0)
                    <flux:button size="sm" icon="check" variant="primary" color="green" wire:click="validateEnAttente">
                        Valider les certificats
                    </flux:button>
                @endif
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-800">
                <tr>
                    <th scope="col"
                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        N° Certificat
                    </th>
                    <th scope="col"
                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Nom
                    </th>
                    <th scope="col"
                        class="hidden sm:table-cell px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Prénom
                    </th>
                    @if ($isStandAlone)
                        <th scope="col"
                            class="hidden sm:table-cell px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Etablissement
                        </th>
                        <th scope="col"
                            class="hidden sm:table-cell px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Formation
                        </th>
                        <th scope="col"
                            class="hidden lg:table-cell px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Information additionnelle
                        </th>
                    @else
                        @foreach($additionalHeaders as $header)
                            @if(!strpos($header, 'de formation'))
                                <th scope="col"
                                    class="hidden lg:table-cell px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ $header }}
                                </th>
                            @endif
                        @endforeach
                    @endif
                    <th scope="col"
                        class="hidden lg:table-cell px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Status
                    </th>

                    <th scope="col"
                        class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($participants as $participant)
                    <tr
                        class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150 ease-in-out"
                    >
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 overflow-hidden rounded-full">

                                    @if($participant->getImage())
                                        <img src="{{ asset('storage/' .$participant->getImage()->file_path) }}"
                                             alt="{{ $participant->personneCertifies->nom }}"
                                             class="h-10 w-10 object-cover">
                                    @else
                                        <div class="h-10 w-10 flex items-center justify-center bg-red-100 dark:bg-red-900 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $participant->numero_certificat }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 dark:text-white">{{ $participant->nom }}</div>
                        </td>
                        <td class="hidden sm:table-cell px-6 py-4">
                            <div class="text-sm text-gray-900 dark:text-white">{{ $participant->prenom }}</div>
                        </td>
                        @if ($isStandAlone)
                            <td class="hidden lg:table-cell px-6 py-4">
                                <div
                                    class="text-sm text-gray-900 dark:text-white">{{ $participant->getEntiteEmmeteurs()->nomination }}</div>
                            </td>
                            <td class="hidden md:table-cell px-6 py-4">
                                <div
                                    class="text-sm text-gray-900 dark:text-white">{{ $participant->formationReel->formation->titre }}</div>
                                <div
                                    class="text-xs text-gray-900 dark:text-white">{{ $participant->formationReel->formation->description }}</div>
                            </td>
                            <td class="hidden sm:table-cell px-6 py-4">
                                @foreach($participant->formation_data as $header => $formation)
                                    @if(!strpos($header, 'de formation'))
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            <span class="font-semibold underline">{{ strtoupper($header) }}</span> : {{ $formation }}
                                        </div>
                                    @endif
                                @endforeach
                            </td>
                        @else
                            @foreach($participant->formation_data as $header => $formation)
                                @if(!strpos($header, 'de formation'))
                                    <td class="hidden sm:table-cell px-6 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white">{{ $formation }}</div>
                                    </td>
                                @endif
                            @endforeach
                        @endif
                        <td class="px-6 py-4">
                            <div class="text-sm {{ $participant->getStatusTextColor() }}">{{ strtoupper($participant->status) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex gap-2">
                            <flux:button size="sm"
                                         tooltip="Détails et modification d'un certificat"
                                         href="{{ Route::generate('admin.certificates-view', ['id' => $participant->id]) }}" wire:navigate
                                         variant="outline" icon="eye"
                                         class="px-3 py-1 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 transition-colors duration-150 text-xs flex items-center">
                            </flux:button>
                            @if ($isStandAlone && \App\Constant\CertificateConstant::STATUS_EN_ATTENTE == $participant->status)
                                <flux:button size="sm" tooltip="Valider"
                                             wire:click="validateCertificate({{ $participant->id }})"
                                             variant="primary" color="blue" icon="check"
                                             class="px-3 py-1 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 transition-colors duration-150 text-xs flex items-center">
                                </flux:button>
                            @endif
                        </td>
                    </tr>

                @endforeach

                @if(count($participants) === 0)
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-lg font-medium">Aucun participant pour cette formation</p>
                            </div>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            {{ $participants->links() }}
        </div>
    </div>
</div>
