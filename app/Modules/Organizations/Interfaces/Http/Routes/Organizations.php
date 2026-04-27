<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Organizations\Interfaces\Http\Controllers\OrganizationController;

Route::prefix('organizations')->middleware(['jwt', 'throttle:api'])->group(function () {
    Route::get('/', [OrganizationController::class, 'index'])
        ->middleware('is.root');

    Route::post('/', [OrganizationController::class, 'store']);

    Route::get('/{id}', [OrganizationController::class, 'show'])
        ->middleware('is.root');

    Route::put('/{id}', [OrganizationController::class, 'update'])
        ->middleware('can.manage.organization');

    Route::delete('/{id}', [OrganizationController::class, 'destroy'])
        ->middleware('can.manage.organization');
});
