<?php

namespace App\Contract\Repositories;

use App\Models\Formation;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface FormationRepositoryInterface extends RepositoryInterface
{
    /**
     * Get all formations
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get paginated formations
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginated(int $perPage = 10): LengthAwarePaginator;

    /**
     * Get formations by entity ID
     *
     * @param int $entiteEmmeteurId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getByEntityId(int $entiteEmmeteurId, int $perPage = 10): LengthAwarePaginator;

    /**
     * Create a new formation
     *
     * @param array $data
     * @return Formation
     */
    public function create(array $data): Formation;

    /**
     * Update a formation
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete a formation
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Implementation of RepositoryInterface methods
     */

    /**
     * Get all formations (paginated)
     *
     * @return Paginator
     */
    public function all(): Paginator;

    /**
     * Search formations
     *
     * @param String $search
     * @return Paginator
     */
    public function search(String $search = ''): Paginator;

    /**
     * Find formation by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model;

    public function upCreate(array $data, array $condition = []): Formation;
}
