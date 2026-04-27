<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Projects\Interfaces\Http\Controllers\ProjectController;

Route::prefix('projects')->middleware(['jwt', 'throttle:api'])->group(function () {
    Route::get('/', [ProjectController::class, 'index'])
        ->middleware('is.root');

    Route::post('/', [ProjectController::class, 'store'])
        ->middleware('is.root');

    Route::get('/{id}', [ProjectController::class, 'show'])
        ->middleware('is.root');

    Route::put('/{id}', [ProjectController::class, 'update'])
        ->middleware('is.root');

    Route::delete('/{id}', [ProjectController::class, 'destroy'])
        ->middleware('is.root');
});
