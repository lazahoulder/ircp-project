<?php

namespace App\Services;

use App\Models\Formation;
use App\Contract\Repositories\FormationRepositoryInterface;
use App\Services\CertificateService;
use App\Services\Interfaces\FormationServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class FormationService implements FormationServiceInterface
{
    /**
     * @var FormationRepositoryInterface
     */
    protected $formationRepository;

    /**
     * @var CertificateService
     */
    protected $certificateService;

    /**
     * FormationService constructor.
     *
     * @param FormationRepositoryInterface $formationRepository
     * @param CertificateService $certificateService
     */
    public function __construct(
        FormationRepositoryInterface $formationRepository,
        CertificateService $certificateService
    ) {
        $this->formationRepository = $formationRepository;
        $this->certificateService = $certificateService;
    }

    /**
     * Get all formations
     *
     * @return Collection
     */
    public function getAllFormations(): Collection
    {
        return $this->formationRepository->getAll();
    }

    /**
     * Get paginated formations
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedFormations(int $perPage = 10): LengthAwarePaginator
    {
        return $this->formationRepository->getPaginated($perPage);
    }

    /**
     * Get formations by entity ID
     *
     * @param int $entiteEmmeteurId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getFormationsByEntityId(int $entiteEmmeteurId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->formationRepository->getByEntityId($entiteEmmeteurId, $perPage);
    }

    /**
     * Search formations
     *
     * @param string $search
     * @param int|null $entiteEmmeteurId
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function searchFormations(string $search, ?int $entiteEmmeteurId = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->formationRepository->searchWithFilters($search, $entiteEmmeteurId, $perPage);
    }

    /**
     * Find formation by ID
     *
     * @param int $id
     * @return Formation|null
     */
    public function findFormationById(int $id): ?Formation
    {
        return $this->formationRepository->findById($id);
    }

    /**
     * Create a new formation
     *
     * @param array $data
     * @param UploadedFile|null $certificateFile
     * @return Formation
     * @throws \Exception If the certificate template is invalid
     */
    public function createFormation(array $data, ?UploadedFile $certificateFile = null): Formation
    {
        $formationData = $data;

        if ($certificateFile) {
            // Store the certificate file temporarily for validation
            $tempPath = $certificateFile->storeAs('temp', 'temp_certificate_' . time() . '.' . $certificateFile->getClientOriginalExtension());
            $fullTempPath = storage_path('app/' . $tempPath);

            try {
                // Validate the certificate template
                $validationResult = $this->certificateService->validateCertificateTemplate($fullTempPath);

                if (!$validationResult['valid']) {
                    // Delete the temporary file
                    Storage::delete($tempPath);

                    // Throw an exception with details about missing placeholders
                    throw new \Exception('Le modèle de certificat ne contient pas tous les placeholders requis: ' .
                        implode(', ', $validationResult['missing']));
                }

                // If valid, store the file permanently
                $certificatePath = $certificateFile->store('certificats', 'public');
                $formationData['modele_certificat'] = $certificatePath;

                // Delete the temporary file
                Storage::delete($tempPath);
            } catch (\Exception $e) {
                // Delete the temporary file in case of any error
                Storage::delete($tempPath);

                // Rethrow the exception
                throw $e;
            }
        }

        return $this->formationRepository->create($formationData);
    }

    /**
     * Update a formation
     *
     * @param int $id
     * @param array $data
     * @param UploadedFile|null $certificateFile
     * @return bool
     * @throws \Exception If the certificate template is invalid
     */
    public function updateFormation(int $id, array $data, ?UploadedFile $certificateFile = null): bool
    {
        $formation = $this->formationRepository->findById($id);
        if (!$formation) {
            return false;
        }

        $formationData = $data;

        if ($certificateFile) {
            // Store the certificate file temporarily for validation
            $tempPath = $certificateFile->storeAs('temp', 'temp_certificate_' . time() . '.' . $certificateFile->getClientOriginalExtension());
            $fullTempPath = storage_path('app/' . $tempPath);

            try {
                // Validate the certificate template
                $validationResult = $this->certificateService->validateCertificateTemplate($fullTempPath);

                if (!$validationResult['valid']) {
                    // Delete the temporary file
                    Storage::delete($tempPath);

                    // Throw an exception with details about missing placeholders
                    throw new \Exception('Le modèle de certificat ne contient pas tous les placeholders requis: ' .
                        implode(', ', $validationResult['missing']));
                }

                // Delete the old file if it exists
                if ($formation->modele_certificat) {
                    Storage::disk('public')->delete($formation->modele_certificat);
                }

                // If valid, store the file permanently
                $certificatePath = $certificateFile->store('certificats', 'public');
                $formationData['modele_certificat'] = $certificatePath;

                // Delete the temporary file
                Storage::delete($tempPath);
            } catch (\Exception $e) {
                // Delete the temporary file in case of any error
                Storage::delete($tempPath);

                // Rethrow the exception
                throw $e;
            }
        }

        return $this->formationRepository->update($id, $formationData);
    }

    /**
     * Delete a formation
     *
     * @param int $id
     * @return bool
     */
    public function deleteFormation(int $id): bool
    {
        $formation = $this->formationRepository->findById($id);
        if (!$formation) {
            return false;
        }

        // Delete the certificate file if it exists
        if ($formation->modele_certificat) {
            Storage::disk('public')->delete($formation->modele_certificat);
        }

        return $this->formationRepository->delete($id);
    }
}
