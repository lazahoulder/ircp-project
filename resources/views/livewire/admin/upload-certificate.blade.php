<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Téléchargement de certificats</h2>

            <form wire:submit="uploadFile">
                <div class="mb-4">
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                        Fichier Excel (.xlsx, .xls)
                    </label>
                    <input
                        type="file"
                        id="file"
                        wire:model="file"
                        class="block w-full text-sm text-gray-500
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-md file:border-0
                               file:text-sm file:font-semibold
                               file:bg-blue-50 file:text-blue-700
                               hover:file:bg-blue-100"
                        accept=".xlsx,.xls"
                    />
                    @error('file') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-start mt-4">
                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-50 cursor-not-allowed"
                    >
                        <span wire:loading.remove wire:target="uploadFile">Télécharger</span>
                        <span wire:loading wire:target="uploadFile">Traitement en cours...</span>
                    </button>
                </div>

                @if($uploadStatus === 'success')
                    <div class="mt-4 p-4 bg-green-50 text-green-700 rounded-md">
                        Le fichier a été téléchargé et traité avec succès.
                    </div>
                @elseif($uploadStatus === 'error')
                    <div class="mt-4 p-4 bg-red-50 text-red-700 rounded-md">
                        Une erreur s'est produite lors du traitement du fichier. Veuillez vérifier le format et réessayer.
                    </div>
                @endif

                <div class="mt-4">
                    <p class="text-sm text-gray-600">
                        <strong>Note:</strong> Le fichier Excel doit contenir les colonnes suivantes:
                    </p>
                    <ul class="list-disc list-inside text-sm text-gray-600 ml-4 mt-2">
                        <li>PHOTO</li>
                        <li>NUMERRO CERTIFICAT</li>
                        <li>NOM</li>
                        <li>PRENOM</li>
                        <li>DATE DE NAISSANCE</li>
                        <li>NATIONALITE</li>
                        <li>CATEGORIE</li>
                        <li>ENGINS</li>
                        <li>DATE DE FORMATION</li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
</div>
