<?php

namespace App\Providers;

use App\Models\Certificate;
use App\Models\EntiteEmmeteurs;
use App\Observers\CertificateObserver;
use App\Observers\EntiteEmmeteurObserver;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS for all URLs when not in local environment
        /*if (request()->getHost() != 'localhost') {
            URL::forceScheme('https');
        }*/
        EntiteEmmeteurs::observe(EntiteEmmeteurObserver::class);
        Certificate::observe(CertificateObserver::class);
    }
}
