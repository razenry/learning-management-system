<?php

use App\Modules\Subscriptions\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::prefix('subscriptions')->middleware('auth:sanctum')->group(function () {
    Route::post('/', [SubscriptionController::class, 'store']);
    Route::get('user/{user}', [SubscriptionController::class, 'userSubscription']);
});
