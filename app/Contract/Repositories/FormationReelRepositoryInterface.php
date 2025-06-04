<?php

namespace App\Contract\Repositories;

use App\Models\FormationReel;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface FormationReelRepositoryInterface extends RepositoryInterface
{
    /**
     * Get all formation reels
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Get paginated formation reels
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginated(int $perPage = 10): LengthAwarePaginator;

    /**
     * Get formation reels by formation ID
     *
     * @param int $formationId
     * @return Collection
     */
    public function getByFormationId(int $formationId): Collection;

    /**
     * Create a new formation reel
     *
     * @param array $data
     * @return FormationReel
     */
    public function create(array $data): FormationReel;

    /**
     * Update a formation reel
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete a formation reel
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Count existing certificates for a formation in a specific year
     *
     * @param int $formationId
     * @param int $year
     * @return int
     */
    public function countCertificatesForFormationInYear(int $formationId, int $year): int;

    /**
     * Implementation of RepositoryInterface methods
     */

    /**
     * Get all formation reels (paginated)
     *
     * @return Paginator
     */
    public function all(): Paginator;

    /**
     * Search formation reels
     *
     * @param String $search
     * @return Paginator
     */
    public function search(String $search = ''): Paginator;

    /**
     * Find formation reel by ID
     *
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model;
}
