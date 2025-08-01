<?php

namespace App\Livewire\Admin;

use App\Constant\EntiteEmmeteursConstant;
use App\Livewire\ListEntiteEmmeteurs;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class ListeEtablissement extends ListEntiteEmmeteurs
{
    use WithPagination;

    #[Url]
    public string $status = '';

    #[On('launch-search')]
    public function listesnDoSearch($query = '', $status = '')
    {
        $this->query = $query;
        $this->status = $status;
        $this->search();
    }

    public function mount($hasSearch = true)
    {
        parent::mount($hasSearch);
    }

    public function validateEtablissement($id)
    {
        //dd($id);
        $centite = $this->service->update(['status' => EntiteEmmeteursConstant::STATUS_VALID], $id);
        $this->dispatch('$refresh');
        LivewireAlert::title('Validation')
            ->text('L\'établissement a été bien validé')
            ->success()
            ->show();
    }

    public function render()
    {
        return view('livewire.admin.liste-etablissement' , [
            'entiteEmmeteurs' => $this->service->searchByStatus($this->query, $this->status)
        ]);
    }
}
