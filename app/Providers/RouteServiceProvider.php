<?php

namespace App\Providers;

use App\Services\HashidsService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
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
        // Macro pour hacher les IDs dans les URLs générées
        Route::macro('generate', function ($name, $parameters = [], $absolute = true) {
            $hashidsService = new HashidsService();
            $newParameters = [];

            foreach ($parameters as $key => $value) {
                if (is_numeric($value) && strpos($key, 'id') !== false) {
                    $newParameters[$key] = $hashidsService->encode($value);
                } else {
                    $newParameters[$key] = $value;
                }
            }

            return route($name, $newParameters, $absolute);
        });
    }
}
