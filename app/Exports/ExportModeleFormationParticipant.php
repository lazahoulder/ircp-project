<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportModeleFormationParticipant implements FromArray, WithHeadings, WithColumnWidths
{


    public function array(): array
    {
        return [];
    }

    public function headings(): array
    {
        return [
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

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 30,
            'D' => 30,
            'E' => 30,
            'F' => 30,
            'G' => 30,
            'H' => 30,
            'I' => 30,
            'J' => 30,
        ];
    }
}
