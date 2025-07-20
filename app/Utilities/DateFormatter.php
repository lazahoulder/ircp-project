<?php

namespace App\Utilities;

use App\Contract\Utilities\DateFormatterInterface;
use Carbon\Carbon;
use DateTime;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class DateFormatter implements DateFormatterInterface
{
    public function formatDate($value, string $format = 'Y-m-d'): ?string
    {
        if ($value === '0/0/0' || empty($value)) {
            return null;
        }
        if (is_numeric($value) && $value > 0) {
            // Convertir une date Excel (nombre de jours depuis 1900) en Carbon
            return Carbon::createFromDate(1899, 12, 30)->addDays($value)->format($format);
        }
        // Gérer les formats de date courants
        $formats = [
            'd/m/y',   // 01/06/25
            'd-m-Y',   // 01-06-2025
            'Y-m-d',   // 2025-06-01
            'd/m/Y',   // 01/06/2025
            'm/d/Y',   // 06/01/2025 (pour compatibilité)
        ];

        foreach ($formats as $inputFormat) {
            try {
                $date = Carbon::createFromFormat($inputFormat, $value);
                if ($date !== false) {
                    return $date->format($format);
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return $value;
    }

    public function formatTrainingDate($value): ?string
    {
        if (is_numeric($value) && $value > 0) {
            // Convertir une date Excel en Y-m-d
            return Carbon::createFromDate(1899, 12, 30)->addDays($value)->format('Y-m-d');
        }
        if (preg_match('/^\d{2}\/\d{2}\/\d{2}$/', $value)) {
            // Gérer les dates au format JJ/MM/AA
            try {
                return Carbon::createFromFormat('d/m/y', $value)->format('Y-m-d');
            } catch (\InvalidArgumentException $e) {
                return null;
            }
        }
        // Conserver les chaînes comme "Janvier 2025-juin 2025"
        return $value;
    }
}
