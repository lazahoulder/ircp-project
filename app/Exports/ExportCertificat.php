<?php

namespace App\Exports;

use App\Contract\Utilities\ImageStorageInterface;
use App\Services\CertificateService;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ExportCertificat implements FromCollection, WithHeadings, WithDrawings, WithEvents, WithColumnWidths
{
    protected $certificates;
    public function __construct(
        private CertificateService $certificateService,
        private ImageStorageInterface $imageStorage,
        private ?int $formationReelId = null
    )
    {
        $this->certificates = $this->certificateService->getCertificate($this->formationReelId);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->certificates->map(function ($item) {
            return [
                'NUMERO CERTIFICAT' => $item->numero_certificat,
                'Nom' => $item->nom,
                'PRENOM' => $item->prenom,
            ];
        });
    }

    /**
     * @throws Exception
     */
    public function drawings()
    {
        $drawings = [];

        $row = 2; // Commencez à la ligne 2 (après l'en-tête)

        foreach ($this->certificates as $certificate) {
            $qrCodeUrl = $certificate->qrcode_url;
            if (file_exists($qrCodeUrl)) {

                $drawing = new Drawing();
                $drawing->setName('QrCODE');
                $drawing->setDescription('This is my QRCODE');
                $drawing->setPath($qrCodeUrl);
                $drawing->setHeight(150);

                $drawing->setCoordinates('D' . $row); // Colonne C, ligne correspondante
                $drawings[] = $drawing;
            } else {
                Log::error("QRCODE non trouvée : " . $qrCodeUrl);
            }
            $row++;
        }

        return $drawings;
    }

    public function headings(): array
    {
        return ['NUMERO CERTIFICAT', 'Nom', 'PRENOM', 'QR CODE'];
    }

    public function registerEvents(): array
    {
        $certificates = $this->certificates;
        return [
            AfterSheet::class => function (AfterSheet $event) use ($certificates) {

                $row = 2;
                foreach ($certificates as $certificate) {
                    $event->sheet->getRowDimension($row)->setRowHeight(150);
                    $row++;
                }
            },
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 30,
            'D' => 30,
        ];
    }
}
