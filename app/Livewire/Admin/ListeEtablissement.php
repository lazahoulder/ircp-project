<?php

namespace App\Livewire\Admin;

use App\Livewire\ListEntiteEmmeteurs;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class ListeEtablissement extends ListEntiteEmmeteurs
{
    use WithPagination;

    #[On('launch-search')]
    public function listesnDoSearch($query = '')
    {
        $this->query = $query;
        $this->search();
    }

    public function mount($hasSearch = true)
    {
        parent::mount($hasSearch);
    }

    public function render()
    {
        return view('livewire.admin.liste-etablissement' , [
            'entiteEmmeteurs' => $this->service->search($this->query)
        ]);
    }
}
