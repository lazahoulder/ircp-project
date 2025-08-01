<?php

namespace App\Utilities;

use App\Contract\Utilities\DateFormatterInterface;
use App\Contract\Utilities\ExcelReaderInterface;
use App\Contract\Utilities\ImageStorageInterface;
use App\Models\Image;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Psr\Log\LoggerInterface;

class ExcelReader implements ExcelReaderInterface
{

    public function __construct(
        protected ImageStorageInterface $imageStorage,
        protected DateFormatterInterface $dateFormatter,
        protected LoggerInterface $logger
    )
    {
    }

    public function read(string $filePath, array $headerValidate = []): array
    {
        $spreadsheet = IOFactory::load($filePath);
        $result = [];
        $duplicateWarnings = [];
        $headerErrors = [];

        foreach ($spreadsheet->getAllSheets() as $sheetIndex => $worksheet) {
            $sheetName = $worksheet->getTitle();
            $data = [];
            $images = [];
            $errors = $this->validateWorkSheet($worksheet, $headerValidate);

            if (!empty($errors['errors'])) {
                $headerErrors[] = $errors;
                continue;
            }

            // Récupérer les images
            $this->logger->debug("Feuille: $sheetName, Nombre d'images: " . count($worksheet->getDrawingCollection()));
            foreach ($worksheet->getDrawingCollection() as $index => $drawing) {
                if ($drawing instanceof Drawing) {
                    $cell = $drawing->getCoordinates();
                    $rowIndex = (int) preg_replace('/[^0-9]/', '', $cell);
                    $column = preg_replace('/[0-9]+/', '', $cell);

                    if ($column !== 'A') {
                        $this->logger->warning("Image à $cell dans la feuille $sheetName n'est pas dans la colonne A.");
                        continue;
                    }

                    if (isset($images[$cell])) {
                        $duplicateWarnings[] = "Duplication détectée dans la feuille $sheetName à la cellule $cell.";
                        continue;
                    }

                    $rowData = $worksheet->rangeToArray('A' . $rowIndex . ':K' . $rowIndex)[0];
                    $certificateNumber = $rowData[1] ?? 'unknown_' . $rowIndex;
                    $extension = $drawing->getExtension();
                    $imageName = preg_replace('/\s+/', '',str_replace('/', '_', $certificateNumber) . '.' . $extension);


                    $relativePath = $this->imageStorage->saveImage(
                        $drawing->getPath(),
                        $imageName,
                        'public/images'
                    );

                    $image = Image::create([
                        'file_name' => $imageName,
                        'file_path' => $relativePath,
                    ]);

                    $images[$cell] = $image->id;
                    $this->logger->debug("Image trouvée à $cell dans la feuille $sheetName, sauvegardée comme $relativePath");
                }
            }

            // Lire toutes les données
            $rows = $worksheet->toArray();
            $headers = array_shift($rows);

            foreach ($rows as $rowIndex => $row) {
                $rowData = array_combine($headers, $row);

                if (isset($rowData['DATE DE NAISSANCE'])) {
                    $rowData['DATE DE NAISSANCE'] = $this->dateFormatter->formatDate(
                        $rowData['DATE DE NAISSANCE']
                    );
                }

                if (isset($rowData['DATE DE DEBUT'])) {
                    $rowData['DATE DE DEBUT'] = $this->dateFormatter->formatDate(
                        $rowData['DATE DE DEBUT']
                    );
                }

                if (isset($rowData['DATE DE FIN'])) {
                    $rowData['DATE DE FIN'] = $this->dateFormatter->formatDate(
                        $rowData['DATE DE FIN']
                    );
                }

                $cellAddress = 'A' . ($rowIndex + 2);
                $rowData['PHOTO'] = $images[$cellAddress] ?? null;

                $data[] = $rowData;
            }

            $result[$sheetName] = $data;
        }

        if (!empty($duplicateWarnings)) {
            $this->logger->warning("Problèmes de duplication détectés : " . implode(', ', $duplicateWarnings));
        }

        return [
            'data' => $result,
            'headerErrors' => $headerErrors,
        ];
    }

    public function getHeader(string $filePath)
    {
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();
        return array_shift($rows);
    }

    protected function validateWorkSheet(Worksheet $worksheet, array $headerValidate = []) : array
    {
        $rows = $worksheet->toArray();
        $headers = array_shift($rows);

        if (empty($headerValidate)) {
            return [];
        }

        $errors = array_diff($headerValidate, array_map('strtoupper', $headers));

        return [
            'name' => $worksheet->getTitle(),
            'errors' => $errors,
        ];
    }
}
