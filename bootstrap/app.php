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
            'can.view.users' => \App\Modules\Users\Interfaces\Http\Middlewares\CanViewUsers::class,
            'can.manage.user' => \App\Modules\Users\Interfaces\Http\Middlewares\CanManageUser::class,
            'can.delete.user' => \App\Modules\Users\Interfaces\Http\Middlewares\CanDeleteUser::class,
            'is.root' => \App\Modules\Users\Interfaces\Http\Middlewares\IsRoot::class,
            'can.manage.project' => \App\Modules\Users\Interfaces\Http\Middlewares\CanManageProject::class,
            'can.manage.organization' => \App\Modules\Users\Interfaces\Http\Middlewares\CanManageOrganization::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
