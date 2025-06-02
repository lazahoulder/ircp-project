<?php

namespace App\Providers;

use App\Repositories\FormationRepository;
use App\Repositories\FormationReelRepository;
use App\Contract\Repositories\FormationRepositoryInterface;
use App\Contract\Repositories\FormationReelRepositoryInterface;
use App\Services\FormationService;
use App\Services\FormationReelService;
use App\Services\Interfaces\FormationServiceInterface;
use App\Services\Interfaces\FormationReelServiceInterface;
use Illuminate\Support\ServiceProvider;

class FormationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register Repositories
        $this->app->bind(FormationRepositoryInterface::class, FormationRepository::class);
        $this->app->bind(FormationReelRepositoryInterface::class, FormationReelRepository::class);

        // Register Services
        $this->app->bind(FormationServiceInterface::class, FormationService::class);
        $this->app->bind(FormationReelServiceInterface::class, FormationReelService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
