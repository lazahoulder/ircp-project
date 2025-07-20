<?php

namespace App\Livewire\Admin\Formation;

use App\Services\Admin\ImportFormationService;
use Illuminate\Support\Facades\Log;
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
            $service->processUploadFile($path, $this->entiteEmmeteurId);

            $this->uploadStatus = 'success';
            $this->reset('file');
            $this->dispatch('formations-imported');
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
