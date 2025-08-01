<?php

namespace App\Contract\Utilities;

interface DateFormatterInterface
{
    public function formatDate($value, string $format = 'Y-m-d'): ?string;
    public function formatTrainingDate($value): ?string;
}
