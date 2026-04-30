<?php

use App\Modules\Reports\Controllers\AdminReportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'role:admin|superadmin'])->prefix('admin/reports')->group(function () {
    Route::get('dashboard', [AdminReportController::class, 'dashboard']);
    Route::get('finance', [AdminReportController::class, 'finance']);
    Route::get('attendance', [AdminReportController::class, 'attendance']);
    Route::get('hafiz', [AdminReportController::class, 'hafiz']);
});
