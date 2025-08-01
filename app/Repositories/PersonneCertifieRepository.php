<?php

namespace App\Repositories;

use App\Contract\Repositories\PersonneCertifieRepositoryInterface;
use App\Models\PersonneCertifies;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;

class PersonneCertifieRepository implements PersonneCertifieRepositoryInterface
{

    public function all(): Paginator
    {
        return PersonneCertifies::paginate(15);
    }

    public function search(string $search = ''): Paginator
    {
        $query = PersonneCertifies::query();

        if ($search) {
            $query->where('nom', 'like', '%' . $search . '%')
                ->orWhere('prenom', 'like', '%' . $search . '%');
        }

        return $query->latest()->paginate(10);
    }

    public function find(int $id): ?Model
    {
        return PersonneCertifies::find($id);
    }

    public function create(array $data): PersonneCertifies
    {
        return PersonneCertifies::create($data);
    }

    public function upCreate(array $data, array $conditions = [])
    {
        if (empty($conditions)) {
            return $this->create($data);
        }

        return PersonneCertifies::updateOrCreate($conditions, $data);
    }
}
