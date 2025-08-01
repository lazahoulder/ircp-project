<?php

namespace App\Services\Interfaces;

use App\Models\Formation;
use App\Services\FormationService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

interface FormationServiceInterface
{
    /**
     * Get all formations
     *
     * @return Collection
     */
    public function getAllFormations(): Collection;

    /**
     * Get paginated formations
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedFormations(int $perPage = 10): LengthAwarePaginator;

    /**
     * Get formations by entity ID
     *
     * @param int $entiteEmmeteurId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getFormationsByEntityId(int $entiteEmmeteurId, int $perPage = 10): LengthAwarePaginator;

    /**
     * Search formations
     *
     * @param string $search
     * @param int|null $entiteEmmeteurId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function searchFormations(string $search, ?int $entiteEmmeteurId = null, int $perPage = 10): LengthAwarePaginator;

    /**
     * Find formation by ID
     *
     * @param int $id
     * @return Formation|null
     */
    public function findFormationById(int $id): ?Formation;

    /**
     * Create a new formation
     *
     * @param array $data
     * @return Formation
     */
    public function createFormation(array $data): Formation;

    /**
     * Update a formation
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateFormation(int $id, array $data): bool;

    /**
     * Delete a formation
     *
     * @param int $id
     * @return bool
     */
    public function deleteFormation(int $id): bool;

    /**
     * @param array $data
     * @param UploadedFile|null $certificateFile
     * @return Formation
     */
    public function saveFormation(array $data, ?UploadedFile $certificateFile = null): Formation;

    public function addCertificatModele(Formation $formation, UploadedFile $certificateFile);
}
