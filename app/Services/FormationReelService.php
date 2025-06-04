<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Formation;
use App\Models\FormationReel;
use App\Models\PersonneCertifies;
use App\Contract\Repositories\FormationReelRepositoryInterface;
use App\Contract\Repositories\FormationRepositoryInterface;
use App\Services\Interfaces\FormationReelServiceInterface;
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
        FormationRepositoryInterface $formationRepository
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
     * @param UploadedFile $participantsFile
     * @return FormationReel
     */
    public function createFormationReel(
        int $formationId,
        string $dateDebut,
        string $dateFin,
        UploadedFile $participantsFile
    ): FormationReel {
        // Store the Excel file
        $filePath = $participantsFile->store('realizations', 'public');

        // Create a new FormationReel
        $formationReel = $this->formationReelRepository->create([
            'formation_id' => $formationId,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'participants_file' => $filePath,
        ]);

        // Process the participants file
        $this->processParticipantsFile($formationReel, $participantsFile);

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
        $fullPath = Storage::disk('public')->path($formationReel->participants_file);
        $fileExtension = strtolower($participantsFile->getClientOriginalExtension());

        try {
            // Required columns
            $requiredColumns = ['nom', 'prenom', 'adresse', 'date de naissance', 'date de certification'];

            // Get the headers and data based on file type
            $headers = [];
            $records = [];

            if ($fileExtension === 'csv') {
                // Read CSV file
                $csv = Reader::createFromPath($fullPath, 'r');
                $csv->setHeaderOffset(0);

                // Get headers
                $headers = $csv->getHeader();

                // Get records
                $records = $csv->getRecords();
            } else {
                // Read Excel file
                $data = Excel::toArray([], $fullPath);

                if (!empty($data) && isset($data[0]) && count($data[0]) > 0) {
                    // Get headers from first row
                    $headers = $data[0][0];

                    // Get records (skip header row)
                    $rows = array_slice($data[0], 1);
                    $records = [];

                    foreach ($rows as $row) {
                        $record = [];
                        foreach ($headers as $index => $header) {
                            $record[strtolower($header)] = $row[$index] ?? null;
                        }
                        $records[] = $record;
                    }
                }
            }

            // Validate required columns
            $missingColumns = array_diff($requiredColumns, array_map('strtolower', $headers));

            if (!empty($missingColumns)) {
                throw new \Exception('Le fichier doit contenir les colonnes suivantes: ' . implode(', ', $requiredColumns));
            }

            // Get the formation
            $formation = $this->formationRepository->findById($formationReel->formation_id);

            // Get the year of formation from date_fin
            $formationYear = Carbon::parse($formationReel->date_fin)->format('Y');

            // Count existing certificates for this formation this year
            $existingCertificatesCount = $this->formationReelRepository->countCertificatesForFormationInYear(
                $formation->id,
                $formationYear
            );

            // Process each record from either CSV or Excel
            foreach ($records as $record) {
                // Normalize keys to lowercase for Excel records
                $recordData = [];
                foreach ($record as $key => $value) {
                    $recordData[strtolower($key)] = $value;
                }

                // Create or update PersonneCertifies
                $personneCertifies = PersonneCertifies::firstOrCreate(
                    [
                        'nom' => $recordData['nom'],
                        'prenom' => $recordData['prenom'],
                    ],
                    [
                        'adresse' => $recordData['adresse'],
                        'date_naissance' => Carbon::parse($recordData['date de naissance'])->format('Y-m-d'),
                    ]
                );

                // Generate certificate number
                // Format: 3 first letters of formation + number of trainees for this formation this year + year of formation
                $formationPrefix = strtoupper(substr($formation->titre, 0, 3));
                $certificateNumber = $existingCertificatesCount + 1;
                $certificateNumberPadded = str_pad($certificateNumber, 3, '0', STR_PAD_LEFT);
                $numeroComplet = $formationPrefix . '-' . $certificateNumberPadded . '-' . $formationYear;

                // Create Certificate
                Certificate::create([
                    'numero_certificat' => $numeroComplet,
                    'formation_reel_id' => $formationReel->id,
                    'personne_certifies_id' => $personneCertifies->id,
                    'date_certification' => Carbon::parse($recordData['date de certification'])->format('Y-m-d'),
                ]);

                $existingCertificatesCount++;
            }

            return true;
        } catch (\Exception $e) {
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
}
