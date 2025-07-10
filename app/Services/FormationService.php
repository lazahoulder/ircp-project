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
            try {
                // Get the temporary file path from the uploaded file
                $tempPath = $this->getF($certificateFile);

                // Validate the certificate template using the temporary file
                $validationResult = $this->certificateService->validateCertificateTemplate($tempPath);

                // If validation passes, store the file permanently
                $certificatePath = $certificateFile->store('certificats', 'public');
                $formationData['modele_certificat'] = $certificatePath;

                if (!$validationResult['valid']) {
                    // Delete the temporary file
                    if (file_exists($tempPath)) {
                        unlink($tempPath);
                    }

                    // Throw an exception with details about missing placeholders
                    throw new \Exception('Le modèle de certificat ne contient pas tous les placeholders requis: ' .
                        implode(', ', $validationResult['missing']));
                }


                // If valid, store the file permanently
                $certificatePath = $certificateFile->storeAs('certificats', time() . '.' . $certificateFile->getClientOriginalExtension(), 'public');
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

            $tempPath = $this->getF($certificateFile);

            try {
                // Validate the certificate template
                $validationResult = $this->certificateService->validateCertificateTemplate($tempPath);

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

    /**
     * @param UploadedFile $certificateFile
     * @return string
     * @throws \Exception
     */
    protected function getF(UploadedFile $certificateFile): string
    {
        $tempPath = $certificateFile->getRealPath();

        // Log the temporary file info
        \Log::info('Uploaded file info', [
            'original_name' => $certificateFile->getClientOriginalName(),
            'temp_path' => $tempPath,
            'size' => $certificateFile->getSize(),
            'mime' => $certificateFile->getMimeType(),
            'exists' => file_exists($tempPath) ? 'yes' : 'no',
            'readable' => is_readable($tempPath) ? 'yes' : 'no'
        ]);

        if (!$tempPath || !file_exists($tempPath)) {
            throw new \Exception("Le fichier temporaire n'existe pas ou n'est pas accessible: " . $tempPath);
        }
        return $tempPath;
    }
}
