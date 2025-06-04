<?php

namespace App\Repositories;

use App\Models\Certificate;
use App\Models\FormationReel;
use App\Contract\Repositories\FormationReelRepositoryInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class FormationReelRepository implements FormationReelRepositoryInterface
{
    /**
     * @var FormationReel
     */
    protected $model;

    /**
     * @var Certificate
     */
    protected $certificateModel;

    /**
     * FormationReelRepository constructor.
     *
     * @param FormationReel $model
     * @param Certificate $certificateModel
     */
    public function __construct(FormationReel $model, Certificate $certificateModel)
    {
        $this->model = $model;
        $this->certificateModel = $certificateModel;
    }

    /**
     * Get all formation reels (paginated)
     *
     * @return Paginator
     */
    public function all(): Paginator
    {
        return $this->getPaginated();
    }

    /**
     * Search formation reels
     *
     * @param String $search
     * @return Paginator
     */
    public function search(String $search = ''): Paginator
    {
        $query = $this->model->query();

        if ($search) {
            // Search in related formation's title or description
            $query->whereHas('formation', function($q) use ($search) {
                $q->where('titre', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        return $query->latest()->paginate(10);
    }

    /**
     * Find formation reel by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->findById($id);
    }

    /**
     * Get all formation reels
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * Get paginated formation reels
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->latest()->paginate($perPage);
    }

    /**
     * Get formation reels by formation ID
     *
     * @param int $formationId
     * @return Collection
     */
    public function getByFormationId(int $formationId): Collection
    {
        return $this->model->where('formation_id', $formationId)->get();
    }

    /**
     * Find formation reel by ID
     *
     * @param int $id
     * @return FormationReel|null
     */
    public function findById(int $id): ?FormationReel
    {
        return $this->model->find($id);
    }

    /**
     * Create a new formation reel
     *
     * @param array $data
     * @return FormationReel
     */
    public function create(array $data): FormationReel
    {
        return $this->model->create($data);
    }

    /**
     * Update a formation reel
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $formationReel = $this->findById($id);
        if (!$formationReel) {
            return false;
        }

        return $formationReel->update($data);
    }

    /**
     * Delete a formation reel
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $formationReel = $this->findById($id);
        if (!$formationReel) {
            return false;
        }

        return $formationReel->delete();
    }

    /**
     * Count existing certificates for a formation in a specific year
     *
     * @param int $formationId
     * @param int $year
     * @return int
     */
    public function countCertificatesForFormationInYear(int $formationId, int $year): int
    {
        return $this->certificateModel
            ->whereHas('formationReel', function($query) use ($formationId, $year) {
                $query->where('formation_id', $formationId)
                      ->whereYear('date_fin', $year);
            })
            ->count();
    }
}
