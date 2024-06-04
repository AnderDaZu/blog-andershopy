<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // Si se require cambiar alguna configuración de alguno de los archivos de ruta preestablecidos, se agrega lo siguiente en using, 
        // y se debe comentar tanto web como api
        // using: function () {
        //     Route::middleware('api')
        //          ->prefix('api')
        //          ->group(base_path('routes/api.php'));

        //     Route::middleware('web')
        //          ->group(base_path('routes/web.php'));

        //     Route::middleware('web')
        //          ->prefix('admin')
        //          ->group(base_path('routes/admin.php'));

        // },
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        // then permite registrar nuevos archivos de ruta
        then: function () {
            Route::middleware('web', 'auth')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
