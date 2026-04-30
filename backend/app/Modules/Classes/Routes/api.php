<?php

use App\Modules\Classes\Controllers\ClassController;
use Illuminate\Support\Facades\Route;

Route::prefix('classes')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [ClassController::class, 'index']);
    Route::post('/', [ClassController::class, 'store']);
    Route::post('{class}/schedule', [ClassController::class, 'addSchedule']);
    Route::post('{class}/enroll', [ClassController::class, 'enroll']);
});
