<?php

namespace App\Contract\Utilities;

interface ImageStorageInterface
{
    public function saveImage(string $sourcePath, string $filename, string $storagePath): string;
    public function getImageUrl(string $relativePath): string;

    public function getImagePath(string $relativePath): string;
}
