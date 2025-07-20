<?php

namespace App\Import;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Storage;

class CertificatImport extends StringValueBinder implements ToArray, WithHeadingRow
{
    public $rows = [];
    public $imagesByRow = [];

    public function __construct(private string $path, private string $storagePath = 'public/images')
    {

    }

    public function array(array $array)
    {
        $this->rows[] = $array;
    }


    public function getDrawning()
    {
        if (empty($this->rows)) {
            return [];
        }
        $spreadsheet = IOFactory::load($this->path);

        foreach ($spreadsheet->getAllSheets() as $sheetIndex => $worksheet) {
            $drawings = $worksheet->getDrawingCollection();
            //$headerRow = 1;  // ligne de tes en-têtes
            //$firstDataRow = $headerRow + 1;
            dump(count($drawings));

            foreach ($drawings as $index => $drawing) {

                // ex : "A3"
                $coord = $drawing->getCoordinates();
                $rowIndex = (int) preg_replace('/[^0-9]/', '', $coord); // Extraire le numéro de ligne
                $rowData = $worksheet->rangeToArray('A' . $rowIndex . ':K' . $rowIndex)[0];
                $certificateNumber = $rowData[1] ?? 'unknown_' . $rowIndex; // NUMERRO CERTIFICAT
                $extension = $drawing->getExtension();
                $imageName = str_replace('/', '_', $certificateNumber) . '.' . $extension;
                dump('start line',[$index, $coord, $rowIndex, $imageName], 'End line');

                // exemple : on ne prend que colonne A (photo)

                /*$contents = file_get_contents($drawing->getPath());
                $extension = $drawing->getExtension();
                // Utiliser NUMERRO CERTIFICAT pour nommer l'image

                $this->imagesByRow[$sheetIndex][$index] = [
                    'mime' => $drawing->getExtension(),
                    'image' => base64_encode($contents),
                    'name' => $rowData[1] ?? 'unknown_' . $rowIndex,
                    'personeName' => $imageName
                ];*/
            }
            dd('end');
        }

        return $this->imagesByRow;
    }
}
