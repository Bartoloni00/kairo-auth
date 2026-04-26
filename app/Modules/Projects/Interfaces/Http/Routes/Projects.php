<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Projects\Interfaces\Http\Controllers\ProjectController;

Route::prefix('projects')->middleware('jwt')->group(function () {
    /*
    - Root: puede ver todos los proyectos
    */
    Route::get('/', [ProjectController::class, 'index']);
    /*
    - Root: es el unico que deberia poder crear proyectos
    */
    Route::post('/', [ProjectController::class, 'store']);
    /*
    - Root: puede ver cualquier proyecto
    */
    Route::get('/{id}', [ProjectController::class, 'show']);
    /*
    - Root: puede modificar cualquier proyecto
    */
    Route::put('/{id}', [ProjectController::class, 'update']);
    /*
    - Root: es el unico que deberia poder eliminar proyectos
    */
    Route::delete('/{id}', [ProjectController::class, 'destroy']);
});
