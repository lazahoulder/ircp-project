<?php

namespace App\Livewire\Admin\Formation;

use App\Services\Admin\ImportFormationService;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;

class ImportFormation extends Component
{
    use WithFileUploads;

    #[Rule('required|file|mimes:xlsx,xls|max:10240')]
    public $file;

    public $uploadStatus = '';
    public $isUploading = false;
    public $entiteEmmeteurId;

    public function mount($entiteEmmeteurId)
    {
        $this->entiteEmmeteurId = $entiteEmmeteurId;
    }

    public function uploadFile(ImportFormationService $service)
    {
        $this->validate();

        $this->isUploading = true;

        try {
            $path = $this->file->getRealPath();
            $errors = $service->processUploadFile($path, $this->entiteEmmeteurId);

            $this->uploadStatus = 'success';
            $this->reset('file');

            Flux::modal('import-modal')->close();

            if (count($errors) > 0) {
                $errorHtml = '<ul class="list-disc pl-5">';
                foreach ($errors as $error) {
                    $errorHtml .= '<li>' . htmlspecialchars($error['name']) . ' : ' . htmlspecialchars(implode(', ', $error['errors'])) . '</li>';
                }
                $errorHtml .= '</ul>';
                LivewireAlert::title('Erreur sur les feuille suivant, il y des colonne manquants')
                    ->html($errorHtml)
                    ->warning()
                    ->withConfirmButton('fermer')
                    ->timer(null)
                    ->show();
            } else {
                $this->dispatch('formations-imported');
            }

        } catch (\Exception $e) {
            $this->uploadStatus = 'error';
            $this->addError('file', $e->getMessage());
            Log::error('Error importing formations: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
        } finally {
            $this->isUploading = false;
        }
    }

    public function render()
    {
        return view('livewire.admin.formation.import-formation');
    }
}
