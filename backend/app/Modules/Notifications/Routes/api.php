<?php

use App\Modules\Notifications\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('notifications')->middleware('auth:sanctum')->group(function () {
    Route::post('send', [NotificationController::class, 'send']);
});
