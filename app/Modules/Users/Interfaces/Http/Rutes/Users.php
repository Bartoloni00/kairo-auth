<?php

namespace App\Modules\Users\Interfaces\Http\Rutes;

use Illuminate\Support\Facades\Route;

use App\Modules\Users\Interfaces\Http\Controllers\UserController;

Route::prefix('users')->middleware('jwt')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});
