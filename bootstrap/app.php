<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: [
            __DIR__ . '/../app/Modules/Auth/Interfaces/Http/Rutes/Auth.php',
            __DIR__ . '/../app/Modules/Users/Interfaces/Http/Rutes/Users.php',
            __DIR__ . '/../app/Modules/Organizations/Interfaces/Http/Rutes/Organizations.php',
            __DIR__ . '/../app/Modules/Projects/Interfaces/Http/Rutes/Projects.php',
            __DIR__ . '/../app/Modules/Licenses/Interfaces/Http/Rutes/Licenses.php',
            __DIR__ . '/../app/Modules/Invitations/Interfaces/Http/Rutes/Invitations.php',
            __DIR__ . '/../app/Modules/Auditlogs/Interfaces/Http/Rutes/Auditlogs.php',
        ],
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'jwt' => App\Modules\Auth\Interfaces\Http\Middlewares\JwtMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
