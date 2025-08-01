<?php

namespace App\Services\Interfaces;

use App\Models\Formation;
use App\Models\FormationReel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

interface FormationReelServiceInterface
{
    /**
     * Get all formation reels
     *
     * @return Collection
     */
    public function getAllFormationReels(): Collection;

    /**
     * Get paginated formation reels
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedFormationReels(int $perPage = 10): LengthAwarePaginator;

    /**
     * Get formation reels by formation ID
     *
     * @param int $formationId
     * @return Collection
     */
    public function getFormationReelsByFormationId(int $formationId): Collection;

    /**
     * Find formation reel by ID
     *
     * @param int $id
     * @return FormationReel|null
     */
    public function findFormationReelById(int $id): ?FormationReel;

    /**
     * Create a new formation reel
     *
     * @param int $formationId
     * @param string $dateDebut
     * @param string $dateFin
     * @return FormationReel
     */
    public function createFormationReel(
        int $formationId,
        string $dateDebut,
        string $dateFin
    ): FormationReel;

    /**
     * Process participants file and create certificates
     *
     * @param FormationReel $formationReel
     * @param UploadedFile $participantsFile
     * @return bool
     */
    public function processParticipantsFile(FormationReel $formationReel, UploadedFile $participantsFile): bool;

    /**
     * Update a formation reel
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateFormationReel(int $id, array $data): bool;

    /**
     * Delete a formation reel
     *
     * @param int $id
     * @return bool
     */
    public function deleteFormationReel(int $id): bool;

    public function saveData(array $dataFormationReel): FormationReel;
}
