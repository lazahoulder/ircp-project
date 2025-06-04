<?php

namespace App\Providers;

use App\Contract\Repositories\CertificateRepositoryInterface;
use App\Contract\Repositories\EntiteEmmeteursRepositoryInterface;
use App\Repositories\CertificateRepository;
use App\Repositories\EntiteEmmeteursRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
            CertificateRepositoryInterface::class,
            CertificateRepository::class
        );

        $this->app->bind(
            EntiteEmmeteursRepositoryInterface::class,
            EntiteEmmeteursRepository::class
        );
    }
}
