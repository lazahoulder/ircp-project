<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class CertificateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Create necessary directories for certificate generation
        if (!Storage::exists('temp')) {
            Storage::makeDirectory('temp');
        }

        if (!Storage::exists('certificates')) {
            Storage::makeDirectory('certificates');
        }

        if (!Storage::exists('templates')) {
            Storage::makeDirectory('templates');
        }
    }
}
