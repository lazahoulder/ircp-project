<?php

namespace App\Repositories;

use App\Contract\Repositories\EntiteEmmeteursRepositoryInterface;
use App\Models\EntiteEmmeteurs;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class EntiteEmmeteursRepository implements EntiteEmmeteursRepositoryInterface
{
    public function all(): Paginator
    {
        return EntiteEmmeteurs::paginate(15);
    }

    public function search(string $search = ''): Paginator
    {
        $query = EntiteEmmeteurs::query();

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('nomination', 'like', '%' . $search . '%')
                  ->orWhere('adresse', 'like', '%' . $search . '%');
            });
        }

        return $query->paginate(15);
    }

    public function find(int $id): ?EntiteEmmeteurs
    {
        return EntiteEmmeteurs::find($id);
    }
}
