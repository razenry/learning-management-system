<?php

use App\Modules\Attendance\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

Route::prefix('attendance')->middleware('auth:sanctum')->group(function () {
    Route::post('generate-qr', [AttendanceController::class, 'generateQr']);
    Route::post('scan', [AttendanceController::class, 'scan']);
});
