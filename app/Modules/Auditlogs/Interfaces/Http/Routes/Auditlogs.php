<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Auditlogs\Interfaces\Http\Controllers\AuditLogController;

Route::prefix('audit-logs')->middleware(['jwt', 'is.root', 'throttle:api'])->group(function () {
    Route::get('/', [AuditLogController::class, 'index']);
});
