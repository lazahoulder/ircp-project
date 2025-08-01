<?php

namespace App\Services;

use App\Contract\Utilities\ExcelReaderInterface;
use App\Models\Certificate;
use App\Models\Formation;
use App\Models\FormationReel;
use App\Models\PersonneCertifies;
use App\Contract\Repositories\FormationReelRepositoryInterface;
use App\Contract\Repositories\FormationRepositoryInterface;
use App\Services\Interfaces\FormationReelServiceInterface;
use App\Utilities\ParticipantsFormatDataUtility;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use Maatwebsite\Excel\Facades\Excel;

class FormationReelService implements FormationReelServiceInterface
{
    /**
     * @var FormationReelRepositoryInterface
     */
    protected $formationReelRepository;

    /**
     * @var FormationRepositoryInterface
     */
    protected $formationRepository;

    /**
     * FormationReelService constructor.
     *
     * @param FormationReelRepositoryInterface $formationReelRepository
     * @param FormationRepositoryInterface $formationRepository
     */
    public function __construct(
        FormationReelRepositoryInterface $formationReelRepository,
        FormationRepositoryInterface $formationRepository,
        private PersonneCertifieService $personneCertifieService,
        private CertificateService $certificateService,
        private ExcelReaderInterface $excelReader
    ) {
        $this->formationReelRepository = $formationReelRepository;
        $this->formationRepository = $formationRepository;
    }

    /**
     * Get all formation reels
     *
     * @return Collection
     */
    public function getAllFormationReels(): Collection
    {
        return $this->formationReelRepository->getAll();
    }

    /**
     * Get paginated formation reels
     *
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getPaginatedFormationReels(int $perPage = 10): LengthAwarePaginator
    {
        return $this->formationReelRepository->getPaginated($perPage);
    }

    /**
     * Get formation reels by formation ID
     *
     * @param int $formationId
     * @return Collection
     */
    public function getFormationReelsByFormationId(int $formationId): Collection
    {
        return $this->formationReelRepository->getByFormationId($formationId);
    }

    /**
     * Find formation reel by ID
     *
     * @param int $id
     * @return FormationReel|null
     */
    public function findFormationReelById(int $id): ?FormationReel
    {
        return $this->formationReelRepository->findById($id);
    }

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
        string $dateFin,
    ): FormationReel {
        // Store the Excel file
        /*$filePath = $participantsFile->store('realizations', 'public');*/

        // Create a new FormationReel
        $formationReel = $this->formationReelRepository->create([
            'formation_id' => $formationId,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
        ]);

        // Process the participants file
        //$this->processParticipantsFile($formationReel, $participantsFile);

        return $formationReel;
    }

    /**
     * Process participants file and create certificates
     *
     * @param FormationReel $formationReel
     * @param UploadedFile $participantsFile
     * @return bool
     */
    public function processParticipantsFile(FormationReel $formationReel, UploadedFile $participantsFile): bool
    {
        $fullPath = $participantsFile->getRealPath();
        $requiredColumns = ['PHOTO', 'NUMERO CERTIFICAT', 'NOM', 'PRENOM',  'DATE DE NAISSANCE', 'NATIONALITE'];


        // Required columns
        $excelResult = $this->processExcel($fullPath, $requiredColumns);
        //dd($excelResult);
        $datas = $excelResult['data'];
        $errors = $excelResult['headerErrors'];

        if (count($errors) > 0) {
            $errorHtml = '<ul class="list-disc pl-5">';
            foreach ($errors as $error) {
                $errorHtml .= '<li>' . htmlspecialchars($error['name']) . ' : ' . htmlspecialchars(implode(', ', $error['errors'])) . '</li>';
            }
            $errorHtml .= '</ul>';

            throw new \Exception('IL y des arreurs sur le fichier :<br/> ' . $errorHtml);
        }


        foreach ($datas as $record) {
            foreach ($record as $value) {
                try {
                    $personneCertifieData = ParticipantsFormatDataUtility::formatPersonneCertifieData($value);
                    $condition = ParticipantsFormatDataUtility::formatPersonneCertifieCondition($value);

                    $personneCertifie = $this->personneCertifieService->upCreate($personneCertifieData, $condition);

                    $certificateData = ParticipantsFormatDataUtility::formatCertificateData($value, $requiredColumns);


                    $certificat = $this->certificateService->createCertificateFromFormation($formationReel, $personneCertifie, $certificateData);

                } catch (\Exception $e) {
                    throw new \Exception("Erreur à la ligne " . $e->getMessage());
                }
            }
        }

        return true;
    }

    public function processExcel(string $filePath, array $requiredColumn, string $storagePath = 'images'): array
    {
        try {
            if (!Storage::exists($storagePath)) {
                Storage::makeDirectory($storagePath);
            }
            return $this->excelReader->read($filePath, $requiredColumn);
        } catch (Exception $e) {
            Log::error("Erreur lors du traitement du fichier Excel : " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Update a formation reel
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateFormationReel(int $id, array $data): bool
    {
        return $this->formationReelRepository->update($id, $data);
    }

    /**
     * Delete a formation reel
     *
     * @param int $id
     * @return bool
     */
    public function deleteFormationReel(int $id): bool
    {
        $formationReel = $this->formationReelRepository->findById($id);
        if (!$formationReel) {
            return false;
        }

        // Delete the participants file if it exists
        if ($formationReel->participants_file) {
            Storage::disk('public')->delete($formationReel->participants_file);
        }

        return $this->formationReelRepository->delete($id);
    }

    public function saveData(array $dataFormationReel): FormationReel
    {
        return FormationReel::updateOrCreate($dataFormationReel, $dataFormationReel);
    }

    public static function getEportFileName($formationReelId)
    {
        $formationReel = FormationReel::find($formationReelId);
        $formation = Formation::find($formationReel->formation_id);
        $yearMonth = Carbon::parse($formationReel->date_fin)->format('m_Y');
        $name = preg_replace('/\s+/', '',str_replace('/', '_', $formation->titre));

        return $name . '_' . $yearMonth;
    }

    public function regenerateQrCodeParticipants($formationReelId)
    {
        $participants = $this->certificateService->getCertificate((int)$formationReelId);

        foreach ($participants as $participant)
        {
            $this->certificateService->regenerateQrCode($participant);
        }
    }
}
