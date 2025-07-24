<?php

namespace App\Services;

use App\Contract\Repositories\CertificateRepositoryInterface;
use App\Contract\Utilities\ImageStorageInterface;
use App\Models\Certificate;
use App\Models\FormationReel;
use App\Models\PersonneCertifies;
use BaconQrCode\Renderer\GDLibRenderer;
use BaconQrCode\Writer;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\TemplateProcessor;

class CertificateService
{
    /**
     * Required placeholders that must be present in certificate templates
     */
    private const REQUIRED_PLACEHOLDERS = [
        'numero_certificat',
        'nom',
        'prenom',
        'date_certification',
        'formation_titre',
        'etablissement',
        'qrcode'
    ];

    public function __construct(
        private CertificateRepositoryInterface $certificateRepository,
        private ImageStorageInterface          $imageStorage
    )
    {

    }

    /**
     * Validate a certificate template file for required placeholders
     *
     * @param string $templatePath Path to the template file
     * @return array ['valid' => bool, 'missing' => array] Validation result and missing placeholders
     * @throws \Exception If the template file cannot be processed
     */
    public function validateCertificateTemplate(string $templatePath): array
    {
        //return ['valid' => true];
        try {
            // Check if the file exists
            if (!file_exists($templatePath)) {
                throw new \Exception("Template file not found: {$templatePath}");
            }

            // Create a template processor to extract variables
            $templateProcessor = new TemplateProcessor($templatePath);

            // Get all variables in the template
            $templateVariables = $templateProcessor->getVariables();

            // Check for missing required placeholders
            $missingPlaceholders = [];
            foreach (self::REQUIRED_PLACEHOLDERS as $placeholder) {
                if (!in_array($placeholder, $templateVariables)) {
                    $missingPlaceholders[] = $placeholder;
                }
            }

            return [
                'valid' => empty($missingPlaceholders),
                'missing' => $missingPlaceholders
            ];
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error validating certificate template: ' . $e->getMessage());

            // Rethrow with a more specific message
            throw new \Exception('Unable to validate certificate template: ' . $e->getMessage());
        }
    }

    /**
     * @param string $search
     * @return Paginator<Certificate>
     */
    public function searchCertificate(string $search = ''): Paginator
    {
        return $this->certificateRepository->search($search);
    }

    /**
     * Generate a certificate number based on establishment name and year
     *
     * @param string $establishmentName
     * @param int $year
     * @return string
     */
    public function generateCertificateNumber(string $establishmentName, int $year): string
    {
        // Create a prefix from the establishment name (first 3 characters uppercase)
        $prefix = strtoupper(substr(preg_replace('/[^a-zA-Z0-9]/', '', $establishmentName), 0, 3));

        // Get the count of certificates for this establishment and year
        $count = Certificate::query()
                ->join('formation_reels', 'certificates.formation_reel_id', '=', 'formation_reels.id')
                ->join('formations', 'formation_reels.formation_id', '=', 'formations.id')
                ->join('entite_emmeteurs', 'formations.entite_emmeteur_id', '=', 'entite_emmeteurs.id')
                ->where('entite_emmeteurs.nomination', $establishmentName)
                ->whereYear('certificates.date_certification', $year)
                ->count() + 1;

        // Format: PREFIX-YEAR-SEQUENCE (e.g., ABC-2023-00001)
        return sprintf('%s-%d-%05d', $prefix, $year, $count);
    }

    /**
     * Generate a QR code image for certificate download
     *
     * @param int $certificateId
     * @return string Path to the generated QR code image
     */
    private function generateQrCodeUrl(int $certificateId): string
    {
        // Generate the download URL for the certificate
        $searchUrl = url(route('search.details', ['id' => $certificateId]));

        // Create a temporary directory for QR codes if it doesn't exist
        $tempDir = storage_path('app/temp/qrcodes');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        // Generate a unique filename for the QR code
        $qrCodePath = $tempDir . '/qrcode_' . $certificateId . '_' . time() . '.png';

        try {
            // Create QR code
            $renderer = new GDLibRenderer(400);
            $writer = new Writer($renderer);
            $writer->writeFile($searchUrl, $qrCodePath);

            // Save the QR code to a file
            //file_put_contents($qrCodePath, $result->getString());

            // Log success
            Log::info('QR code generated successfully at: ' . $qrCodePath);

            return $qrCodePath;
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error generating QR code: ' . $e->getMessage());

            // Return an empty string or throw an exception
            throw new \Exception('Unable to generate QR code: ' . $e->getMessage());
        }
    }

    /**
     * Generate a certificate from a Word template
     *
     * @param string $templatePath
     * @param array $replacements
     * @param string $outputFileName
     * @return string Path to the generated file
     */
    public function generateCertificateFromTemplate(string $templatePath, array $replacements, string $outputFileName): string
    {
        try {
            // Verify template exists
            if (!file_exists($templatePath)) {
                throw new \Exception("Template file not found: {$templatePath}");
            }

            // Create a template processor
            $templateProcessor = new TemplateProcessor($templatePath);


            // Handle QR code separately
            if (!empty($replacements['qrcode_url'])) {
                try {
                    // Get the QR code image path
                    $qrCodePath = $replacements['qrcode_url'];

                    //dump($qrCodePath);

                    // Log the path for debugging
                    Log::info('Using QR code from: ' . $qrCodePath);

                    // Check if the QR code image exists
                    if (!file_exists($qrCodePath)) {
                        throw new \Exception("QR code image not found at: {$qrCodePath}");
                    }

                    // Add the QR code image to the document
                    // Replace the ${qrcode} placeholder with the actual QR code image
                    $templateProcessor->setImageValue('qrcode', [
                        'path' => $qrCodePath,
                        'width' => 125,
                        'height' => 125
                    ]);

                    unset($replacements['qrcode_url']);

                    // Log success
                    Log::info('QR code added to certificate');
                } catch (\Exception $e) {
                    // Log the error but continue processing
                    Log::error('Error adding QR code to certificate: ' . $e->getMessage());
                }
            }

            // Handle QR code separately
            if (!empty($replacements['photo'])) {
                try {
                    // Get the QR code image path
                    $imagePath = $replacements['photo'];

                    //dump($qrCodePath);

                    // Log the path for debugging
                    Log::info('Using image from: ' . $imagePath);

                    // Check if the QR code image exists
                    if (!file_exists($imagePath)) {
                        throw new \Exception("Image not found at: {$imagePath}");
                    }

                    // Add the QR code image to the document
                    // Replace the ${qrcode} placeholder with the actual QR code image
                    $templateProcessor->setImageValue('photo', [
                        'path' => $imagePath,
                        'width' => 100,
                        'height' => 100
                    ]);


                    unset($replacements['photo']);

                    // Log success
                    Log::info('QR code added to certificate');
                } catch (\Exception $e) {
                    // Log the error but continue processing
                    Log::error('Error adding QR code to certificate: ' . $e->getMessage());
                }
            }

            // Replace placeholders in the template
            foreach ($replacements as $key => $value) {
                $templateProcessor->setValue($key, $value ?? '');
            }


            // Ensure certificates directory exists
            $certificatesDir = storage_path('app/certificates');
            if (!file_exists($certificatesDir)) {
                mkdir($certificatesDir, 0755, true);
            }

            // Define output path for the Word document
            $outputPath = $certificatesDir . '/' . $outputFileName . '.docx';

            // Save the processed template
            $templateProcessor->saveAs($outputPath);

            // Verify the file was created
            if (!file_exists($outputPath)) {
                throw new \Exception("Failed to create certificate file at {$outputPath}");
            }

            return $outputPath;
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error generating certificate: ' . $e->getMessage());

            // Rethrow a more specific exception
            throw new \Exception('Unable to generate certificate: ' . $e->getMessage());
        }
    }

    /**
     * Create a certificate
     *
     * @param array $data
     * @param string|null $templatePath
     * @return Certificate
     * @throws \Exception
     */
    public function createCertificate(array $data, ?string $templatePath = null): Certificate
    {
        // Get the formation reel
        $formationReel = FormationReel::findOrFail($data['formation_reel_id']);

        // Get the establishment name
        $establishmentName = null;
        if ($formationReel->formation && $formationReel->formation->entiteEmmeteurs) {
            $establishmentName = $formationReel->formation->entiteEmmeteurs->nomination;
        }

        // Use a default name if establishment name is null
        if ($establishmentName === null) {
            $establishmentName = 'DEFAULT';
        }

        // Get the year from the certification date
        $certificationDate = Carbon::parse($data['date_certification']);
        $year = $certificationDate->year;

        // Generate certificate number
        $data['numero_certificat'] = $data['numero_certificat'] ?? $this->generateCertificateNumber($establishmentName, $year);

        // Create the certificate
        $certificate = $this->certificateRepository->create($data);

        $qrCode = $this->generateQrCodeUrl($certificate->id);

        $certificate->qrcode_url = $qrCode;

        $certificate->save();


        return $certificate;
    }

    /**
     * @throws \Exception
     */
    public function createCertificateFromFormation(FormationReel $formationReel, PersonneCertifies $personneCertifies, array $data): Certificate
    {
        $dataCertificate = [
            'formation_reel_id' => $formationReel->id,
            'personne_certifies_id' => $personneCertifies->id,
            'date_certification' => $data['date_certification'] ?? null,
            'numero_certificat' => $data['numero_certificat'],
            'formation_data' => $data['formation_data'] ?? [],
            'image_id' => $data['image_id'] ?? null,
        ];

        $certificate = $this->certificateRepository->create($dataCertificate);

        $qrCode = $this->generateQrCodeUrl($certificate->id);

        $certificate->qrcode_url = $qrCode;

        $certificate->save();


        return $certificate;
    }

    /**
     * Import certificates from Excel or CSV
     *
     * @param string $filePath
     * @param string|null $templatePath
     * @return array
     */
    public function importCertificatesFromFile(string $filePath, ?string $templatePath = null): array
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $results = ['success' => 0, 'failed' => 0, 'certificates' => []];


        // Process Excel file
        $data = Excel::toArray([], $filePath)[0];

        // Get headers from first row
        $headers = array_shift($data);

        foreach ($data as $row) {
            try {
                $record = array_combine($headers, $row);
                $certificate = $this->processImportRecord($record, $templatePath);
                $results['success']++;
                $results['certificates'][] = $certificate;
            } catch (\Exception $e) {
                $results['failed']++;
            }
        }


        return $results;
    }

    /**
     * Process a single record from import
     *
     * @param array $record
     * @param string|null $templatePath
     * @return Certificate
     */
    private function processImportRecord(array $record, ?string $templatePath = null): Certificate
    {
        // Map the record to certificate data
        // This mapping will depend on your import file structure
        $data = [
            'formation_reel_id' => $record['formation_reel_id'],
            'personne_certifies_id' => $record['personne_certifies_id'],
            'date_certification' => $record['date_certification'],
            // Add more fields as needed
        ];

        // Create the certificate
        return $this->createCertificate($data, $templatePath);
    }

    /**
     * Download a certificate
     *
     * @param int $certificateId
     * @return string Path to the generated certificate file
     * @throws \Exception If certificate generation fails
     */
    public function downloadCertificate(int $certificateId): string
    {
        try {
            // Find the certificate
            $certificate = Certificate::with(['formationReel.formation', 'personneCertifies'])->findOrFail($certificateId);

            // Generate a unique filename
            $outputFileName = Str::slug($certificate->personneCertifies->nom . '-' .
                $certificate->personneCertifies->prenom . '-' . $certificate->numero_certificat);

            // Check if the certificate already has a generated file
            $existingFilePath = storage_path('app/certificates/' . $outputFileName . '.docx');

            // Temporarily force regeneration of all certificates to ensure they have QR codes
            // This can be removed once all certificates have been regenerated
            if (file_exists($existingFilePath)) {
                unlink($existingFilePath);
                Log::info('Deleted existing certificate to force regeneration with QR code');
            }

            // Get the template path from the formation
            $templatePath = null;
            if ($certificate->formationReel && $certificate->formationReel->formation &&
                !empty($certificate->formationReel->formation->modele_certificat)) {
                $formationTemplatePath = Storage::path($certificate->formationReel->formation->modele_certificat);

                if (file_exists($formationTemplatePath)) {
                    $templatePath = $formationTemplatePath;
                }
            }

            // If no specific template was found, use the default template
            if ($templatePath === null) {
                $defaultTemplatePath = storage_path('app/templates/default_certificate.docx');

                // Force regeneration of the default template to ensure it has the latest QR code placeholder
                // This is temporary and can be removed once the QR code issue is resolved
                if (file_exists($defaultTemplatePath)) {
                    unlink($defaultTemplatePath);
                    Log::info('Deleted existing default template to force regeneration');
                }

                // Create the default template
                $this->createDefaultTemplate();

                // Verify the template was created
                if (!file_exists($defaultTemplatePath)) {
                    throw new \Exception("Failed to create default template");
                }

                $templatePath = $defaultTemplatePath;
            }

            // Get the establishment name
            $establishmentName = 'N/A';
            if ($certificate->formationReel && $certificate->formationReel->formation &&
                $certificate->formationReel->formation->entiteEmmeteurs) {
                $establishmentName = $certificate->formationReel->formation->entiteEmmeteurs->nomination;
            }

            // Prepare replacements for the template
            $replacements = [
                'numero_certificat' => $certificate->numero_certificat ?? 'N/A',
                'nom' => $certificate->personneCertifies->nom ?? 'N/A',
                'prenom' => $certificate->personneCertifies->prenom ?? 'N/A',
                'date_certification' => $certificate->date_certification ?
                    Carbon::parse($certificate->date_certification)->format('d/m/Y') : 'N/A',
                'formation_titre' => $certificate->formationReel && $certificate->formationReel->formation ?
                    $certificate->formationReel->formation->titre : 'N/A',
                'etablissement' => $establishmentName,
                'qrcode_url' => $certificate->qrcode_url ?? $this->generateQrCodeUrl($certificate->id),
                // Add more replacements as needed
            ];

            // Add photo if available
            $image = $certificate->getImage();
            if (file_exists($this->imageStorage->getImagePath($image->file_path))) {
                $replacements['photo'] = $this->imageStorage->getImagePath($image->file_path);
            }

            // Generate the certificate
            return $this->generateCertificateFromTemplate($templatePath, $replacements, $outputFileName);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error downloading certificate: ' . $e->getMessage());

            // Rethrow with a more user-friendly message
            throw new \Exception('Unable to download certificate: ' . $e->getMessage());
        }
    }

    /**
     * Create a default certificate template
     *
     * @return void
     */
    private function createDefaultTemplate(): void
    {
        try {
            // Ensure the templates directory exists with proper permissions
            $templatesPath = storage_path('app/templates');
            if (!file_exists($templatesPath)) {
                mkdir($templatesPath, 0755, true);
            }

            // Create a placeholder image for the photo if it doesn't exist
            $placeholderPath = storage_path('app/templates/placeholder.png');
            if (!file_exists($placeholderPath)) {
                // Create a simple placeholder image
                $image = imagecreatetruecolor(100, 100);
                $bgColor = imagecolorallocate($image, 200, 200, 200);
                $textColor = imagecolorallocate($image, 50, 50, 50);

                // Fill the background
                imagefilledrectangle($image, 0, 0, 100, 100, $bgColor);

                // Add text
                imagestring($image, 2, 15, 40, 'Photo', $textColor);

                // Save the image
                imagepng($image, $placeholderPath);
                imagedestroy($image);

                Log::info('Created placeholder image at: ' . $placeholderPath);
            }

            // Create a basic Word document as the default template
            $phpWord = new \PhpOffice\PhpWord\PhpWord();

            // Add a section
            $section = $phpWord->addSection();

            // Add a title
            $section->addText('CERTIFICAT', ['bold' => true, 'size' => 24], ['alignment' => 'center']);
            $section->addTextBreak(2);

            // Add a placeholder for the photo
            $section->addText('Photo du titulaire:', ['bold' => true, 'size' => 12]);
            $section->addImage(
                storage_path('app/templates/placeholder.png'),
                [
                    'width' => 100,
                    'height' => 100,
                    'alignment' => 'center',
                    'wrappingStyle' => 'inline'
                ]
            );
            $section->addTextBreak(1);

            // Add certificate content
            $section->addText('Numéro de certificat: ${numero_certificat}', ['bold' => true, 'size' => 14]);
            $section->addTextBreak();
            $section->addText('Ce certificat est décerné à:', ['size' => 12]);
            $section->addTextBreak();
            $section->addText('${prenom} ${nom}', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
            $section->addTextBreak(2);
            $section->addText('Pour avoir complété avec succès la formation:', ['size' => 12]);
            $section->addTextBreak();
            $section->addText('${formation_titre}', ['bold' => true, 'size' => 14], ['alignment' => 'center']);
            $section->addTextBreak(2);
            $section->addText('Date de certification: ${date_certification}', ['size' => 12]);
            $section->addTextBreak();
            $section->addText('Établissement: ${etablissement}', ['size' => 12]);

            // Add QR code placeholder
            $section->addTextBreak(2);
            $section->addText('Scannez ce QR code pour vérifier ce certificat:', ['size' => 12], ['alignment' => 'center']);
            $section->addTextBreak();

            // Create a simple placeholder for the QR code
            // Just add a text with the placeholder variable name
            // This will be replaced with the actual QR code image
            $section->addText('${qrcode}', ['size' => 12], ['alignment' => 'center']);

            // Add a note about the QR code
            $section->addTextBreak();
            $section->addText('Ce certificat peut être vérifié en ligne.', ['italic' => true, 'size' => 10], ['alignment' => 'center']);

            // Define the output path
            $outputPath = $templatesPath . '/default_certificate.docx';

            // Save the document
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save($outputPath);

            // Log success
            Log::info('Default certificate template created at: ' . $outputPath);

            // Verify the file was created
            if (!file_exists($outputPath)) {
                throw new \Exception("Failed to create default template at {$outputPath}");
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error creating default template: ' . $e->getMessage());

            // Rethrow a more specific exception
            throw new \Exception('Unable to create default certificate template: ' . $e->getMessage());
        }
    }

    public function getCertificate(?int $formationReelId)
    {
        return Certificate::where('formation_reel_id', $formationReelId)->get();
    }

    public function searchCertificateByEntity(string $search, int $formationReelId): LengthAwarePaginator
    {
        return $this->certificateRepository->searchByFormationReelId($search, $formationReelId);
    }

    public function regenerateQrCode(Certificate $participant): void
    {
        if ($participant->qrcode_url) {
            unlink($participant->qrcode_url);
        }
        $participant->qrcode_url = $this->generateQrCodeUrl($participant->id);
        $participant->save();
    }
}
