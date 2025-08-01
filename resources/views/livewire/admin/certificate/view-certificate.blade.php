<?php

use App\Constant\CertificateConstant;
use App\Models\Certificate;
use App\Models\Image;
use App\Services\CertificateService;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

new #[Layout('components.layouts.app')] class extends Component {
    use WithFileUploads;

    public ?Certificate $certificate = null;
    public $photo;
    public array $additionalData = [];
    public array $newData = [[]];
    public bool $showForm = false;
    public ?string $editingKey = null;
    public array $originalData = [];
    public array $editData = [];
    public $editingDate = false;
    public $certificateDate = null;

    protected CertificateService $service;

    public function boot(CertificateService $service)
    {
        $this->service = $service;
    }

    public function mount(Certificate $id): void
    {
        $this->certificate = $id->exists ? $id : null;
        if (!$this->certificate) {
            $this->redirectRoute('certificates.index', [], navigate: true);
        }
        $this->additionalData = $this->certificate->formation_data ?? [];
        $this->originalData = $this->additionalData; // Stocker les données initiales
        $this->certificateDate = $this->certificate->date_certification;
    }

    public function updatePhoto(): void
    {
        $this->validate([
            'photo' => 'image|max:2048', // 2MB max
        ]);

        if ($this->photo) {
            if ($this->certificate->getImage()) {
                Storage::disk('public')->delete($this->certificate->getImage()->file_path);
                $this->certificate->getImage()->delete();
            }

            $extension = $this->photo->getExtension();
            $imageName = preg_replace('/\s+/', '', str_replace('/', '_', $this->certificate->numero_certificat) . '.' . $extension);


            $path = $this->photo->store('images', 'public');
            $image = Image::create([
                'file_name' => $imageName,
                'file_path' => $path,
            ]);
            $this->certificate->image_id = $image->id;
            $this->certificate->save();

            $this->dispatch('$refresh');
            LivewireAlert::title('Photos')
                ->text('L\'image a été mise à jour')
                ->success()
                ->show();
        }
    }

    public function startEditing($key): void
    {
        $this->editingKey = $key;
        $this->editData = [
            'key' => $key,
            'value' => $this->additionalData[$key] ?? '',
        ];
    }

    public function cancelEditing(): void
    {
        $this->additionalData = $this->originalData; // Restaurer les données initiales
        $this->editingKey = null;
        $this->editData = [];
    }

    public function regenerateQrCode()
    {
        $this->service->regenerateQrCode($this->certificate);
        $this->dispatch('$refresh');
        LivewireAlert::title('QR-CODE')
            ->text('Le qr-cde a été bien regénéré')
            ->success()
            ->show();
    }

    public function validateCertificate()
    {
        $this->certificate->update(['status' => CertificateConstant::STATUS_VALID]);
        $this->dispatch('$refresh');
        LivewireAlert::title('Validation')
            ->text('Le certificat a été bien validé')
            ->success()
            ->show();
    }

    public function updateAdditionalData(): void
    {
        $this->validate([
            'editData.key' => 'required|string|max:255',
            'editData.value' => 'required|string|max:255',
        ], [], [
            'editData.key' => 'clé',
            'editData.value' => 'valeur'
        ]);

        $oldKey = $this->editingKey;
        $newKey = $this->editData['key'];

        if ($oldKey !== $newKey) {
            $this->additionalData[$newKey] = $this->editData['value'];
            unset($this->additionalData[$oldKey]);
        } else {
            $this->additionalData[$oldKey] = $this->editData['value'];
        }

        $this->certificate->update([
            'formation_data' => $this->additionalData,
        ]);

        $this->originalData = $this->additionalData;
        $this->editingKey = null;
        $this->editData = [];
        $this->dispatch('notify', ['message' => 'Information complémentaire mise à jour.', 'type' => 'success']);
    }

    public function deleteAdditionalData($key): void
    {
        if (array_key_exists($key, $this->additionalData)) {
            unset($this->additionalData[$key]);
            $this->certificate->update([
                'formation_data' => $this->additionalData,
            ]);
            $this->originalData = $this->additionalData;
            $this->editingKey = null;
            $this->dispatch('notify', ['message' => 'Information complémentaire supprimée.', 'type' => 'success']);
        }
    }

    public function addNewDataField(): void
    {
        $this->newData[] = [];
    }

    public function removeNewDataField($index): void
    {
        if (isset($this->newData[$index])) {
            unset($this->newData[$index]);
            $this->newData = array_values($this->newData);
        }
    }

    public function saveNewDataField($index): void
    {
        $this->validate([
            "newData.{$index}.key" => 'required|string|max:255',
            "newData.{$index}.value" => 'required|string|max:255',
        ], [], [
            "newData.{$index}.key" => 'clé',
            "newData.{$index}.value" => 'valeur'
        ]);

        if (!empty($this->newData[$index]['key']) && !empty($this->newData[$index]['value'])) {
            $this->additionalData[$this->newData[$index]['key']] = $this->newData[$index]['value'];
            $this->certificate->update([
                'formation_data' => $this->additionalData,
            ]);
            $this->originalData = $this->additionalData;
            unset($this->newData[$index]);
            $this->newData = array_values($this->newData);
            if (empty($this->newData)) {
                $this->newData = [[]];
            }
            $this->dispatch('notify', ['message' => 'Information complémentaire ajoutée.', 'type' => 'success']);
        }
    }

    public function toggleForm(): void
    {
        $this->showForm = !$this->showForm;
        $this->newData = [[]];
    }

    public function toogleEditDate()
    {
        $this->editingDate = !$this->editingDate;
    }

    public function editDateField()
    {
        $this->certificate->update(['date_certification' => $this->certificateDate]);
        $this->toogleEditDate();
    }
}; ?>

<div>
    <h1 class="text-3xl font-semibold  text-gray-100 text-center">
        Détail d'un certificat
    </h1>
    <div class="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex-shrink-0 p-4">
            <a href="{{ route('admin.certificates') }}"
               class="flex items-center text-blue-200 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour à la liste des certificats
            </a>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <!-- Certificate Header -->
            <div class="bg-gradient-to-r from-blue-800 to-indigo-900 px-4 sm:px-6 py-4">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                    <h2 class="text-lg sm:text-xl font-bold text-white break-words">
                        Certificat N° {{ $certificate->numero_certificat }}
                    </h2>
                    <div class="flex flex-row gap-2 sm:gap-4">
                        <flux:button
                                wire:click="regenerateQrCode"
                                variant="primary"
                                title="Régénérer le QR-CODE"
                                color="zinc">
                            <flux:icon name="qr-code" class="h-5 w-5"/>
                        </flux:button>
                        <flux:button
                                href="{{ Route::generate('admin.certificates.qr-code', ['id' => $certificate->id]) }}"
                                target="_blank"
                                variant="primary"
                                title="Télécharger le QR-CODE"
                                color="orange">
                            <flux:icon name="folder-arrow-down" class="h-5 w-5"/>
                        </flux:button>
                        @if (CertificateConstant::STATUS_EN_ATTENTE === $certificate->status)
                            <flux:button variant="primary"
                                         title="Valider le certificat"
                                         color="green"
                                         wire:click="validateCertificate"
                            >
                                <flux:icon name="check" class="h-5 w-5"/>
                            </flux:button>
                        @endif
                        <flux:button
                                variant="primary"
                                title="Imprimer le certificat"
                                color="blue"
                                href="{{ route('certificate.download', ['id' => $certificate->id]) }}"
                                target="_blank"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </flux:button>
                    </div>
                </div>
            </div>

            <!-- Certificate Content -->
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div>
                        <livewire:admin.certificate.image-form :certificate="$certificate"/>
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Date de
                                certification</h3>
                            @if($editingDate)
                                <div class="flex flex-row gap-2">
                                    <flux:input wire:model="certificateDate" type="date" placeholder="Date de certification"/>
                                    <button wire:click="editDateField"
                                            class="text-green-500 text-semibold hover:text-green-700">
                                        <flux:icon name="check" class="h-5 w-5"/>
                                    </button>
                                    <button wire:click="toogleEditDate"
                                            class="text-gray-500 hover:text-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            @else
                                <p class="text-lg font-semibold text-gray-900 dark:text-white" tooltip="Cliquer pour modifier">{{ Carbon::parse($certificateDate)->format('d/m/Y') }}</p>
                                <button
                                    wire:click="toogleEditDate"
                                    class="text-blue-500 hover:text-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Formation</h3>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $certificate->formationReel->formation->titre }}</p>
                            <p class="text-lg text-gray-900 dark:text-white">{{ $certificate->formationReel->formation->description }}</p>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Centre
                                éméteur</h3>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $certificate->getEntiteEmmeteurs()->nomination }}</p>
                        </div>
                        <div>
                            <h4 class="text-xs font-medium text-gray-500 dark:text-gray-400">Période de
                                formation</h4>
                            <p class="text-sm text-gray-700 dark:text-gray-300">
                                Du {{ Carbon::parse($certificate->formationReel->date_debut)->format('d/m/Y') }}
                                au {{ Carbon::parse($certificate->formationReel->date_fin)->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Informations
                        complémentaires</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if(!empty($certificate->formation_data))
                            @foreach($certificate->formation_data as $key => $value)
                                <div class="flex items-center p-2 m-2 gap-2 shadow">
                                    @if($editingKey === $key)
                                        <flux:input wire:model="editData.key" placeholder="Clé (ex. Note)"/>
                                        <flux:input wire:model="editData.value" placeholder="Valeur"/>
                                        <button wire:click="updateAdditionalData"
                                                class="text-green-500 text-semibold hover:text-green-700">
                                            <flux:icon name="check" class="h-5 w-5"/>
                                        </button>
                                        <button wire:click="cancelEditing"
                                                class="text-gray-500 hover:text-gray-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    @else
                                        <div class="flex-grow">
                                            <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400">{{ ucfirst($key) }}</h4>
                                            <p class="text-md text-gray-700 dark:text-gray-300">{{ $value }}</p>
                                        </div>
                                        <button wire:click="startEditing('{{ $key }}')"
                                                class="text-blue-500 hover:text-blue-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <button wire:click="deleteAdditionalData('{{ $key }}')"
                                                class="text-red-500 hover:text-red-700">
                                            <flux:icon name="trash" class="h-5 w-5"/>
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="mt-2 pt-2 dark:border-gray-700">
                    <div class="mt-6">
                        <flux:button icon="{{ $showForm ? 'x-mark' : 'plus' }}" wire:target="toggleForm"
                                     class="ml-2"
                                     color="{{ $showForm ? 'red' : 'blue' }}" variant="primary"
                                     wire:click="toggleForm">
                            {{ $showForm ? 'Annuler' : 'Ajouter une information' }}
                        </flux:button>
                    </div>

                    <!-- Formulaire pour ajouter des informations complémentaires -->
                    @if($showForm)
                        <div class="mt-4">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Ajouter des
                                informations</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @php($indice = 0)
                                @foreach($newData as $index => $data)

                                    <div class="items-center gap-2 mb-2">
                                        <div class="flex gap-2">
                                            <flux:input wire:model="newData.{{ $index }}.key"
                                                        placeholder="Clé (ex. Note)"/>
                                            <flux:input wire:model="newData.{{ $index }}.value"
                                                        placeholder="Valeur"/>
                                            <button wire:click="saveNewDataField({{ $index }})"
                                                    class="text-green-500 hover:text-green-700">
                                                <flux:icon name="check" class="h-5 w-5"/>
                                            </button>
                                            @if ($indice != 0)
                                                <button wire:click="removeNewDataField({{ $index }})"
                                                        class="text-red-500 hover:text-red-700">
                                                    <flux:icon name="trash" class="h-5 w-5"/>
                                                </button>
                                            @endif
                                            @php($indice++)
                                        </div>
                                    </div>

                                @endforeach
                            </div>

                            <flux:button icon="plus-circle"
                                         wire:click="addNewDataField" variant="ghost">
                                Ajouter un autre champ
                            </flux:button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
