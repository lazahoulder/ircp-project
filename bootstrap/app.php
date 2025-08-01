<?php

use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\HashIdMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\SubstituteBindings;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => CheckAdmin::class,
            'hashId' => HashIdMiddleware::class,
            'bindings' => SubstituteBindings::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
