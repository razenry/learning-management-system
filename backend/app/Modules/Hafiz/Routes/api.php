<?php

use App\Modules\Hafiz\Controllers\HafizController;
use Illuminate\Support\Facades\Route;

Route::prefix('hafiz')->middleware('auth:sanctum')->group(function () {
    Route::post('progress', [HafizController::class, 'recordProgress']);
    Route::post('reports', [HafizController::class, 'storeReport']);
    Route::get('student/{student}/progress', [HafizController::class, 'studentProgress']);
});
