<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportModeleParticipant implements FromArray, WithHeadings, WithColumnWidths
{


    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        return ['PHOTO', 'NUMERO CERTIFICAT', 'NOM', 'PRENOM',  'DATE DE NAISSANCE', 'NATIONALITE'];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 30,
            'D' => 30,
            'E' => 30,
            'F' => 30,
        ];
    }
}
