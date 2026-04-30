<?php

use App\Modules\LMS\Controllers\LMSController;
use Illuminate\Support\Facades\Route;

Route::prefix('lms')->middleware('auth:sanctum')->group(function () {
    Route::post('materials', [LMSController::class, 'storeMaterial']);
    Route::post('assignments', [LMSController::class, 'storeAssignment']);
    Route::post('assignments/{assignment}/questions', [LMSController::class, 'addQuestion']);
    Route::post('assignments/{assignment}/submit', [LMSController::class, 'submit']);
});
