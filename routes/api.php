<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FileUploadController;
use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ReportsController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\Api\PropertyController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('verify-otp', [AuthController::class, 'verifyOTP']);
    Route::post('password/send-reset-email', [PasswordResetController::class, 'sendResetPasswordEmail']);
    Route::post('password/reset', [PasswordResetController::class, 'reset']);
});

// Protected Routes
Route::middleware('auth:api')->group(function () {
    // Auth related
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('support', [AuthController::class, 'submit']);
    Route::post('logout', [AuthController::class, 'logout']);

    // Notifications
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::post('{notification}/read', [NotificationController::class, 'markAsRead']);
        Route::post('{notification}/unread', [NotificationController::class, 'markAsUnread']);
    });

    // Roles and Permissions
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class);
    Route::put('roles/{role}/permissions', [RoleController::class, 'updatePermissions']);

    Route::apiResource('properties', PropertyController::class);

    // Modules
    Route::get('modules', [ModuleController::class, 'getModules']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/profile', [UserController::class, 'getProfile']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::put('/users/{user}/edit', [UserController::class, 'updateUserSpecifics']);
});
