<?php

namespace App\Http\Controllers;

use App\Exports\ExportModeleFormationParticipant;
use App\Exports\ExportModeleParticipant;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ModeleController extends Controller
{
    public function downloadFormationExcelModele()
    {
        $export = new ExportModeleFormationParticipant();

        $fileName = 'formation_modele.xlsx';

        return Excel::download($export, $fileName);
    }

    public function downloadParticipantExcelModele()
    {
        $export = new ExportModeleParticipant();

        $fileName = 'participant_modele.xlsx';

        return Excel::download($export, $fileName);
    }
}
