<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('admin/dashboard', AdminController::class)->only(['index']);

Route::prefix('admin')->group(function () {
    // Dashboard route
    Route::resource('dashboard', AdminController::class)->only(['index']);
});
