<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: [
            __DIR__ . '/../app/Modules/Auth/Interface/Http/Rutes/Auth.php',
            __DIR__ . '/../app/Modules/Users/Interface/Http/Rutes/Users.php',
            __DIR__ . '/../app/Modules/Organizations/Interface/Http/Rutes/Organizations.php',
            __DIR__ . '/../app/Modules/Projects/Interface/Http/Rutes/Projects.php',
            __DIR__ . '/../app/Modules/Licenses/Interface/Http/Rutes/Licenses.php',
            __DIR__ . '/../app/Modules/Invitations/Interface/Http/Rutes/Invitations.php',
            __DIR__ . '/../app/Modules/Auditlogs/Interface/Http/Rutes/Auditlogs.php',
        ],
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
