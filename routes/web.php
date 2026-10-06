<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('admin/dashboard', AdminController::class)->only(['index']);

Route::prefix('admin')->group(function () {
    // Show login form
    Route::get('login', [AdminController::class, 'create'])->name('admin.login');
    // Handle login form submission
    Route::post('login', [AdminController::class, 'store'])->name('admin.login.request');
    Route::group(['middleware' => ['admin']], function() {
        // Dashboard route
        Route::resource('dashboard', AdminController::class)->only(['index']);
        // Display Update Password Page
        Route::get('update-password', [AdminController::class, 'edit'])->name('admin.update-password');
        // Verify Password Route
        Route::post('verify-password', [AdminController::class, 'verifyPassword'])->name('admin.verify.password');
        // Update Password Route
        Route::post('update-password', [AdminController::class, 'updatePasswordRequest'])->name('admin.update-password.request');
        // Display Admin Details
        Route::get('update-details', [AdminController::class, 'editDetails'])->name('admin.update-details');
        Route::post('update-details', [AdminController::class, 'updateDetails'])->name('admin.update-details.request');
        // Delete Profile Imafe Route
        Route::post('delete-profile-image', [AdminController::class, 'deleteProfileImage']);
        // Display Subadmins Details
        Route::get('subadmins', [AdminController::class, 'subadmins']);
        Route::post('update-subadmin-status', [AdminController::class, 'updateSubadminStatus']);
        Route::get('add-edit-subadmin/{id?}', [AdminController::class, 'addEditSubadmin']);
        Route::post('add-edit-subadmin/request', [AdminController::class, 'addEditSubadminRequest']);
        Route::get('delete-subadmin/{id}', [AdminController::class, 'deleteSubadmin']);
        Route::get('/update-role/{id}',[AdminController::class,'updateRole']);
        Route::post('/update-role/request',[AdminController::class,'updateRoleRequest']);
        // Admin Logout
        Route::get('logout', [AdminController::class, 'destroy'])->name('admin.logout');
    });
});
