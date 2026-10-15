<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ====================================================================
        // REGISTRO DEL MIDDLEWARE DE ROLES (RBAC)
        // ====================================================================
        // Este alias permite proteger rutas con: ->middleware('role:propietario')
        // Se apoya en el motor InnoDB y el sistema de transacciones ACID de
        // Laravel para garantizar que solo usuarios autorizados accedan a los
        // procesos críticos del taller.
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();