<?php

namespace App\Services;

use App\Constant\EntiteEmmeteursConstant;
use App\Contract\Repositories\EntiteEmmeteursRepositoryInterface;
use App\Models\EntiteEmmeteurs;
use Illuminate\Database\Eloquent\Model;

class EntiteEmmeteursService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private EntiteEmmeteursRepositoryInterface $repository)
    {
    }

    public function create(array $data): EntiteEmmeteurs
    {
        return EntiteEmmeteurs::create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @return bool
     */
    public function update(array $data, $id): bool
    {
        return $this->repository->find($id)->update($data);
    }

    /**
     * @param $id
     * @return bool|null
     */
    public function delete($id): ?bool
    {
        return $this->repository->find($id)->delete();
    }

    /**
     * @param $id
     * @return EntiteEmmeteurs|null
     */
    public function find($id): ?EntiteEmmeteurs
    {
        return $this->repository->find($id);
    }

    public function search(string $search = '')
    {
        return $this->repository->search($search);
    }

    public function searchValide(string $search = '')
    {
        return $this->repository->searchValide($search);
    }

    public function getQuantityBySatus($status = EntiteEmmeteursConstant::STATUS_EN_ATTENTE)
    {
        return $this->repository->getQuantityByStatus($status);
    }
}
