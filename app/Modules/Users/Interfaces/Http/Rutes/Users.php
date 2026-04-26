<?php

namespace App\Modules\Users\Interfaces\Http\Rutes;

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
    Route::get('/{id}', [UserController::class, 'show']);
    /*
    - Root: puede eliminar a cualquier usuario
    - Org Owner (admin de la organizacion): puede eliminar a cualquier usuario de su organizacion
    - Un usuario inferior a admin solo podra eliminar su cuenta personal
    */
    Route::delete('/{id}', [UserController::class, 'destroy']);

    /*
    Por el momento no se validara que el usuario logueado
    sea el dueño del usuario que se esta modificando

    para entrar a una organizacion debes ser el creador o recibir una invitation del dueño de la organizacion
    (esto sera otro token)

    por lo pronto no se implementara la logica de invitaciones ni validaciones por dueño
    */
    Route::post('/{id}/projects', [UserController::class, 'addToProject']);
    Route::post('/{id}/organizations', [UserController::class, 'addToOrganization']);
    Route::delete('/{id}/projects/{projectId}', [UserController::class, 'removeFromProject']);
    Route::delete('/{id}/organizations/{organizationId}', [UserController::class, 'removeFromOrganization']);
    /*
    Estos put en un futuro deberan tener una validacion por email para verificar que el usuario 
    sea el dueño del email
    */
    Route::put('/{id}/email', [UserController::class, 'updateEmail']);
    Route::put('/{id}/password', [UserController::class, 'updatePassword']);
});
