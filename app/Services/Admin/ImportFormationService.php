<?php

namespace App\Services\Admin;

use App\Contract\Utilities\ExcelReaderInterface;
use App\Import\CertificatImport;
use App\Models\FormationReel;
use App\Models\Image;
use App\Models\PersonneCertifies;
use App\Services\CertificateService;
use App\Services\FormationService;
use App\Services\Interfaces\FormationReelServiceInterface;
use App\Services\Interfaces\FormationServiceInterface;
use App\Services\PersonneCertifieService;
use Exception;
use Log;
use Storage;

readonly class ImportFormationService
{
    protected array $requiredColumns;

    public function __construct(
        private FormationServiceInterface     $formationService,
        private ExcelReaderInterface          $excelReader,
        private FormationReelServiceInterface $formationReelService,
        private CertificateService            $certificateService,
        private PersonneCertifieService       $personneCertifieService,
    )
    {
        $this->requiredColumns = [
            'PHOTO',
            'NUMERO CERTIFICAT',
            'NOM',
            'PRENOM',
            'DATE DE NAISSANCE',
            'NATIONALITE',
            'FORMATION',
            'DESCRIPTION',
            'DATE DE DEBUT',
            'DATE DE FIN',
        ];
    }

    /**
     * @throws Exception
     */
    public function processUploadFile(string $fullPath, int $entiteEmmeteurId)
    {
        $datas = $this->processExcel($fullPath);

        foreach ($datas as $record) {
            foreach ($record as $value) {
                try {
                    $certificateData = $this->formatCertificatData($value);
                    $formationData = $this->formatFormationData($value, $entiteEmmeteurId);
                    if (!$formationData['titre']) {
                        continue;
                    }
                    $formation = $this->formationService->saveFormation($formationData);



                    $formationReel = $this->formationReelService->saveData($this->formatFormationReelData($value, $formation->id));

                    $personneCertifie = $this->personneCertifieService->upCreate($this->formatPersonneCertifieData($value), $this->formatPersonneCertifieCondition($value));


                    $certificat = $this->certificateService->createCertificateFromFormation($formationReel, $personneCertifie, $this->formatCertificatData($value));

                    if (isset($certificateData['image_id'])) {
                        $this->personneCertifieService->addPhoto($personneCertifie, $certificateData['image_id']);
                    }

                } catch (\Exception $e) {
                    throw new \Exception("Erreur à la ligne " . $e->getMessage());
                }
            }
        }
    }

    public function processExcel(string $filePath, string $storagePath = 'public/images'): array
    {
        try {
            if (!Storage::exists($storagePath)) {
                Storage::makeDirectory($storagePath);
            }
            return $this->excelReader->read($filePath);
        } catch (Exception $e) {
            Log::error("Erreur lors du traitement du fichier Excel : " . $e->getMessage());
            throw $e;
        }
    }

    protected function formatFormationData(array $data, $entiteEmmeteurId): array
    {
        return [
            'titre' => $data['FORMATION'],
            'description' => $data['DESCRIPTION'],
            'entite_emmeteur_id' => $entiteEmmeteurId,
        ];
    }

    protected function formatCertificatData(array $data): array
    {
        $dataCertificate = [
            'formation_data' => $this->getFormtionAdditionnalData($data),
            'numero_certificat' => preg_replace('/\s+/', '', $data['NUMERO CERTIFICAT']),
            'date_certification' => $data['DATE DE FIN'],
            'image_id' => (int) $data['PHOTO'],
        ];

        if ($data['PHOTO']) {
            $dataCertificate['image_id'] = $data['PHOTO'];
        }

        return $dataCertificate;
    }

    protected function formatFormationReelData(array $data, $formationId): array
    {
        return [
            'formation_id' => $formationId,
            'date_debut' => $data['DATE DE DEBUT'],
            'date_fin' => $data['DATE DE FIN'],
        ];
    }

    protected function getFormtionAdditionnalData(array $data): array
    {
        $formation_data = [];

        foreach ($data as $key => $value) {
            if ($key === '' || $value == '') {
                continue;
            }

            if (!in_array($key, $this->requiredColumns)) {
                $formation_data[strtolower($key)] = $value;
            }
        }

        return $formation_data;
    }

    private function formatPersonneCertifieData(array $data)
    {
        return [
            'nom' => $data['NOM'],
            'prenom' => $data['PRENOM'],
            'date_naissance' => $data['DATE DE NAISSANCE'],
            'nationality' => $data['NATIONALITE'],
        ];
    }

    private function formatPersonneCertifieCondition(array $data)
    {
        return [
            'nom' => trim($data['NOM']),
            'prenom' => trim($data['PRENOM']),
            'nationality' => $data['NATIONALITE'],
        ];
    }
}
