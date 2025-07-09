<?php

namespace App\Repositories;

use App\Constant\EntiteEmmeteursConstant;
use App\Contract\Repositories\EntiteEmmeteursRepositoryInterface;
use App\Models\EntiteEmmeteurs;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder as QueryBuider;

class EntiteEmmeteursRepository implements EntiteEmmeteursRepositoryInterface
{
    protected function searchQuery(string $search = ''): QueryBuider
    {
        $query = EntiteEmmeteurs::query();

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('nomination', 'like', '%' . $search . '%')
                    ->orWhere('adresse', 'like', '%' . $search . '%');
            });
        }

        return $query;
    }

    public function all(): Paginator
    {
        return EntiteEmmeteurs::paginate(15);
    }

    public function search(string $search = ''): Paginator
    {
        return $this->searchQuery($search)->paginate(15);
    }

    public function find(int $id): ?EntiteEmmeteurs
    {
        return EntiteEmmeteurs::find($id);
    }

    public function searchValide(string $search = ''): Paginator
    {
        $query = $this->searchQuery($search);
        $query->where('status', EntiteEmmeteursConstant::STATUS_VALID);

        return $query->paginate(15);
    }

    public function getQuantityByStatus(mixed $status)
    {
        return EntiteEmmeteurs::whereStatus($status)->count();
    }
}
