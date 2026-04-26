<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: [
            __DIR__ . '/../app/Modules/Auth/Interfaces/Http/Routes/Auth.php',
            __DIR__ . '/../app/Modules/Users/Interfaces/Http/Routes/Users.php',
            __DIR__ . '/../app/Modules/Organizations/Interfaces/Http/Routes/Organizations.php',
            __DIR__ . '/../app/Modules/Projects/Interfaces/Http/Routes/Projects.php',
            __DIR__ . '/../app/Modules/Licenses/Interfaces/Http/Routes/Licenses.php',
            __DIR__ . '/../app/Modules/Invitations/Interfaces/Http/Routes/Invitations.php',
            __DIR__ . '/../app/Modules/Auditlogs/Interfaces/Http/Routes/Auditlogs.php',
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
