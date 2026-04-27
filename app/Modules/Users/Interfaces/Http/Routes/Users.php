<?php

use Illuminate\Support\Facades\Route;

use App\Modules\Users\Interfaces\Http\Controllers\UserController;

Route::prefix('users')->middleware(['jwt', 'throttle:api'])->group(function () {
    /*
    - Root: puede ver a todos los usuarios
    - pueden ver usuarios de su misma organizacion y de las organizaciones que tiene acceso
    */
    Route::get('/', [UserController::class, 'index'])
        ->middleware('can.view.users');

    Route::get('/{user_id}', [UserController::class, 'show'])
        ->middleware('can.manage.user')
        ->whereNumber('user_id');

    Route::delete('/{user_id}', [UserController::class, 'destroy'])
        ->middleware('can.delete.user')
        ->whereNumber('user_id');

    Route::post('/{user_id}/projects', [UserController::class, 'addToProject'])
        ->middleware('can.manage.user')
        ->whereNumber('user_id');

    Route::post('/{user_id}/organizations', [UserController::class, 'addToOrganization'])
        ->middleware('can.manage.user')
        ->whereNumber('user_id');

    Route::delete('/{user_id}/projects/{project_id}', [UserController::class, 'removeFromProject'])
        ->middleware('can.manage.user')
        ->whereNumber('user_id')
        ->whereNumber('project_id');

    Route::delete('/{user_id}/organizations/{organization_id}', [UserController::class, 'removeFromOrganization'])
        ->middleware('can.manage.user')
        ->whereNumber('user_id')
        ->whereNumber('organization_id');

    Route::put('/{user_id}/email', [UserController::class, 'updateEmail'])
        ->middleware(['can.manage.user', 'throttle:sensitive'])
        ->whereNumber('user_id');

    Route::put('/{user_id}/password', [UserController::class, 'updatePassword'])
        ->middleware(['can.manage.user', 'throttle:sensitive'])
        ->whereNumber('user_id');
});
