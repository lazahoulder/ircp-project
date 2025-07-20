<?php

namespace App\Contract\Utilities;

interface ExcelReaderInterface
{
    public function read(string $filePath): array;
}
