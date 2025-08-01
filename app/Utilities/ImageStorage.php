<?php

namespace App\Utilities;

use App\Contract\Utilities\ImageStorageInterface;
use Illuminate\Support\Facades\Storage;

class ImageStorage implements ImageStorageInterface
{
    public function saveImage(string $sourcePath, string $filename, string $storagePath): string
    {
        $imageContents = file_get_contents($sourcePath);
        $relativePath = $storagePath . '/' . $filename;
        Storage::put($relativePath, $imageContents);
        return $relativePath;
    }

    public function getImageUrl(string $relativePath): string
    {
        return Storage::url($relativePath);
    }

    public function getImagePath(string $relativePath): string
    {
        return Storage::path($relativePath);
    }
}
