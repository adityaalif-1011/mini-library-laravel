<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            '/kantin/*',
            '/kantin/order',
            '/kantin/payment/*',
            '/kantin/snap-token/*',
            '/order',
            '/payment/*',
            '/snap-token/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();