<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;

Route::get('/user', function (\Illuminate\Http\Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Load Module Routes
$modulePath = app_path('Modules');
if (File::exists($modulePath)) {
    $modules = File::directories($modulePath);
    foreach ($modules as $module) {
        $apiRoutePath = $module . '/Routes/api.php';
        if (File::exists($apiRoutePath)) {
            Route::middleware('api')
                ->group($apiRoutePath);
        }
    }
}
