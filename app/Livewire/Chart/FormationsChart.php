<?php

namespace App\Livewire\Chart;

use App\Models\Certificate;
use App\Models\EntiteEmmeteurs;
use Carbon\Carbon;
use Livewire\Component;

class FormationsChart extends Component
{
    public array $chartData = [];

    public function mount()
    {
        // Exemple : Nombre de formations par statut
        $rawData = Certificate::selectRaw('MONTH(date_certification) as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->startOfYear())
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        //dd($rawData);

        // Créer un tableau avec tous les mois (1 à 12) initialisés à 0
        $chartData = [];
        $today = Carbon::now();
        $month = (int) $today->month;
        for ($i = 1; $i <= $month; $i++) {
            $chartData[$i] = 0;
        }

// Remplir avec les données existantes
        foreach ($rawData as $month => $count) {
            $chartData[$month] = $count;
        }

        $finalData = [];
        foreach ($chartData as $month => $count) {
            $monthName = Carbon::create()->month($month)->locale('fr')->isoFormat('MMMM'); // ex: janvier
            $finalData[$monthName] = $count;
        }

        $this->chartData = $finalData;
    }

    public function render()
    {
        return view('livewire.chart.formations-chart');
    }
}
