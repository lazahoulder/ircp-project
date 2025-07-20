<?php

namespace App\Http\Controllers;

use App\Contract\Utilities\ImageStorageInterface;
use App\Exports\ExportCertificat;
use App\Models\Certificate;
use App\Models\FormationReel;
use App\Services\CertificateService;
use App\Services\FormationReelService;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CertificateController extends Controller
{
    public function __construct(
        private CertificateService $certificateService,
        private ImageStorageInterface $imageStorage,
    )
    {
    }

    /**
     * Download a certificate
     *
     * @param int $id
     * @return BinaryFileResponse
     */
    public function download(int $id): BinaryFileResponse
    {
        try {
            // Generate the certificate
            $filePath = $this->certificateService->downloadCertificate($id);

            // Check if the file exists
            if (!file_exists($filePath)) {
                abort(404, 'Le fichier du certificat n\'a pas pu être généré.');
            }

            // Get the filename from the path
            $filename = basename($filePath);

            // Determine the content type based on file extension
            $contentType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';

            // Return the file as a download
            return response()->download($filePath, $filename, [
                'Content-Type' => $contentType,
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        } catch (\Exception $e) {
            // Log the error
            \Illuminate\Support\Facades\Log::error('Error in certificate download: ' . $e->getMessage());

            // Return a user-friendly error
            abort(500, 'Une erreur est survenue lors de la génération du certificat. Veuillez réessayer plus tard.');
        }
    }

    public function downloadExcel($formationReelId = null)
    {
        $export = new ExportCertificat($this->certificateService, $this->imageStorage,$formationReelId);

        $fileName = FormationReelService::getEportFileName($formationReelId) . '.xlsx';

        return Excel::download($export, $fileName);
    }
}
