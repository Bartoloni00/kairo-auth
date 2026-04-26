<?php

use Illuminate\Support\Facades\Route;

use App\Modules\Users\Interfaces\Http\Controllers\UserController;

Route::prefix('users')->middleware('jwt')->group(function () {
    /*
    - Root: puede ver a todos los usuarios
    - pueden ver usuarios de su misma organizacion y de las organizaciones que tiene acceso
    */
    Route::get('/', [UserController::class, 'index']);
    /*
    - Root: puede ver a todos los usuarios
    - pueden ver usuarios de su misma organizacion y de las organizaciones que tiene acceso
    */
    Route::get('/{user_id}', [UserController::class, 'show'])
        ->whereNumber('user_id');
    /*
    - Root: puede eliminar a cualquier usuario
    - Org Owner (admin de la organizacion): puede eliminar a cualquier usuario de su organizacion
    - Un usuario inferior a admin solo podra eliminar su cuenta personal
    */
    Route::delete('/{user_id}', [UserController::class, 'destroy'])
        ->whereNumber('user_id');

    /*
    Por el momento no se validara que el usuario logueado
    sea el dueño del usuario que se esta modificando

    para entrar a una organizacion debes ser el creador o recibir una invitation del dueño de la organizacion
    (esto sera otro token)

    por lo pronto no se implementara la logica de invitaciones ni validaciones por dueño
    */
    Route::post('/{user_id}/projects', [UserController::class, 'addToProject'])
        ->whereNumber('user_id');
    Route::post('/{user_id}/organizations', [UserController::class, 'addToOrganization'])
        ->whereNumber('user_id');
    Route::delete('/{user_id}/projects/{project_id}', [UserController::class, 'removeFromProject'])
        ->whereNumber('user_id')
        ->whereNumber('project_id');
    Route::delete('/{user_id}/organizations/{organization_id}', [UserController::class, 'removeFromOrganization'])
        ->whereNumber('user_id')
        ->whereNumber('organization_id');
    /*
    Estos put en un futuro deberan tener una validacion por email para verificar que el usuario 
    sea el dueño del email
    */
    Route::put('/{user_id}/email', [UserController::class, 'updateEmail'])
        ->whereNumber('user_id');
    Route::put('/{user_id}/password', [UserController::class, 'updatePassword'])
        ->whereNumber('user_id');
});
