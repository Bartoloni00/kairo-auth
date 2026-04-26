<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Organizations\Interfaces\Http\Controllers\OrganizationController;

Route::prefix('organizations')->middleware('jwt')->group(function () {
    /*
    - Root: puede ver todas las organizaciones
    - Los miembros de una organizacion pueden ver todas las organizaciones en las que estan asociados
    */
    Route::get('/', [OrganizationController::class, 'index']);
    /*
    - Todos pueden crear una organizacion
    - El usuario que crea la organizacion se convierte en el admin de la organizacion
    */
    Route::post('/', [OrganizationController::class, 'store']);
    /*
    - Root: puede ver cualquier organizacion
    - Los miembros de una organizacion pueden ver todas las organizaciones en las que estan asociados
    */
    Route::get('/{id}', [OrganizationController::class, 'show']);
    /*
    - Root: puede modificar cualquier organizacion
    - El admin de la organizacion puede modificar la organizacion
    */
    Route::put('/{id}', [OrganizationController::class, 'update']);
    /*
    - Root: puede eliminar cualquier organizacion
    - El admin de la organizacion puede eliminar la organizacion
    */
    Route::delete('/{id}', [OrganizationController::class, 'destroy']);
});
