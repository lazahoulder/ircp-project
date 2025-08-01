<?php

namespace App\Providers;

use App\Contract\Utilities\DateFormatterInterface;
use App\Contract\Utilities\ExcelReaderInterface;
use App\Contract\Utilities\ImageStorageInterface;
use App\Utilities\DateFormatter;
use App\Utilities\ExcelReader;
use App\Utilities\ImageStorage;
use Illuminate\Support\ServiceProvider;

class UtilitiesServiceProvider extends ServiceProvider
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
        $this->app->bind(
            DateFormatterInterface::class,
            DateFormatter::class
        );

        $this->app->bind(
            ExcelReaderInterface::class,
            ExcelReader::class
        );

        $this->app->bind(
            ImageStorageInterface::class,
            ImageStorage::class
        );

        $this->app->bind(
            ImageStorageInterface::class,
            ImageStorage::class
        );
    }
}
