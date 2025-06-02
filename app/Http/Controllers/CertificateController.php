<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Services\CertificateService;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CertificateController extends Controller
{
    protected CertificateService $certificateService;

    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
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
}
