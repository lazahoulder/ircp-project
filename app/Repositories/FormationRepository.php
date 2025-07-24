<?php

namespace App\Repositories;

use App\Models\Formation;
use App\Contract\Repositories\FormationRepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class FormationRepository implements FormationRepositoryInterface
{
    /**
     * @var Formation
     */
    protected $model;

    /**
     * FormationRepository constructor.
     *
     * @param Formation $model
     */
    public function __construct(Formation $model)
    {
        $this->model = $model;
    }

    /**
     * Get all formations (paginated)
     *
     * @return Paginator
     */
    public function all(): Paginator
    {
        return $this->getPaginated();
    }

    /**
     * Find formation by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->findById($id);
    }

    /**
     * Get all formations
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * Get paginated formations
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->latest()->paginate($perPage);
    }

    /**
     * Get formations by entity ID
     *
     * @param int $entiteEmmeteurId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getByEntityId(int $entiteEmmeteurId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->where('entite_emmeteur_id', $entiteEmmeteurId)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Search formations with entity ID and pagination
     *
     * @param string $search
     * @param int|null $entiteEmmeteurId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function searchByEntiteEmmeteur(string $search, ?int $entiteEmmeteurId = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->query();

        if ($search) {
            $query->where('titre', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
        }

        if ($entiteEmmeteurId) {
            $query->where('entite_emmeteur_id', $entiteEmmeteurId);
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Search formations (implementation of RepositoryInterface method)
     *
     * @param String $search
     * @return Paginator
     */
    public function search(String $search = ''): Paginator
    {
        $query = $this->model->query();

        if ($search) {
            $query->where('titre', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
        }

        return $query->latest()->paginate(10);
    }

    /**
     * Find formation by ID
     *
     * @param int $id
     * @return Formation|null
     */
    public function findById(int $id): ?Formation
    {
        return $this->model->find($id);
    }

    /**
     * Create a new formation
     *
     * @param array $data
     * @return Formation
     */
    public function create(array $data): Formation
    {
        return $this->model->create($data);
    }

    /**
     * Update a formation
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $formation = $this->findById($id);
        if (!$formation) {
            return false;
        }

        return $formation->update($data);
    }

    /**
     * Delete a formation
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $formation = $this->findById($id);
        if (!$formation) {
            return false;
        }

        return $formation->delete();
    }

    public function upCreate(array $data, array $condition = []): Formation
    {
        if (empty($condition)) {
            return $this->create($data);
        }

        return Formation::updateOrCreate($condition, $data);
    }
}
