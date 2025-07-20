<?php

namespace App\Livewire\Admin;

use App\Services\Admin\UploadCertificateService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;

class UploadCertificate extends Component
{
    use WithFileUploads;

    #[Rule('required|file|mimes:xlsx,xls|max:10240')]
    public $file;

    public $uploadStatus = '';
    public $isUploading = false;

    public function uploadFile(UploadCertificateService $service)
    {
        $this->validate();

        $this->isUploading = true;

        try {
            $path = $this->file->getRealPath();
            dd($path);
            $service->processUploadFile($path);

            $this->uploadStatus = 'success';
            $this->reset('file');
        } catch (\Exception $e) {
            $this->uploadStatus = 'error';
        } finally {
            $this->isUploading = false;
        }
    }

    public function render()
    {
        return view('livewire.admin.upload-certificate');
    }
}
