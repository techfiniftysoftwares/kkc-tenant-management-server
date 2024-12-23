<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FileUploadController;
use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    PropertyController,
    UnitController,
    TenantController,
    UnitTenantController,
    PropertyManagerController
};


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



    // Modules
    Route::get('modules', [ModuleController::class, 'getModules']);

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/user/profile', [UserController::class, 'getProfile']);
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::put('/users/{user}/edit', [UserController::class, 'updateUserSpecifics']);



    // Property Routes
    Route::prefix('properties')->group(function () {
        Route::get('/', [PropertyController::class, 'index']);
        Route::post('/', [PropertyController::class, 'store']);
        Route::get('/{id}', [PropertyController::class, 'show']);
        Route::put('/{id}', [PropertyController::class, 'update']);
        Route::delete('/{id}', [PropertyController::class, 'destroy']);
    });

    // Unit Routes
    Route::prefix('units')->group(function () {
        Route::get('/', [UnitController::class, 'index']);
        Route::post('/', [UnitController::class, 'store']);
        Route::get('/{id}', [UnitController::class, 'show']);
        Route::put('/{id}', [UnitController::class, 'update']);
        Route::delete('/{id}', [UnitController::class, 'destroy']);
    });

    // Tenant Routes
    Route::prefix('tenants')->group(function () {
        Route::get('/', [TenantController::class, 'index']);
        Route::post('/', [TenantController::class, 'store']);
        Route::get('/{id}', [TenantController::class, 'show']);
        Route::put('/{id}', [TenantController::class, 'update']);
        Route::delete('/{id}', [TenantController::class, 'destroy']);
    });

    // Lease (UnitTenant) Routes
    Route::prefix('leases')->group(function () {
        Route::get('/', [UnitTenantController::class, 'index']);
        Route::post('/', [UnitTenantController::class, 'store']);
        Route::get('/{id}', [UnitTenantController::class, 'show']);
        Route::put('/{id}', [UnitTenantController::class, 'update']);
        Route::delete('/{id}', [UnitTenantController::class, 'destroy']);

        // Additional lease management routes
        Route::get('/active', [UnitTenantController::class, 'getActiveLeases']);
        Route::get('/overdue', [UnitTenantController::class, 'getOverduePayments']);
        Route::put('/{id}/payment', [UnitTenantController::class, 'updatePaymentStatus']);
        Route::put('/{id}/terminate', [UnitTenantController::class, 'terminateLease']);
        Route::put('/{id}/renew', [UnitTenantController::class, 'renewLease']);
        Route::get('/{id}/payments', [UnitTenantController::class, 'getPaymentHistory']);
    });

    // Property Manager Routes
    Route::prefix('property-managers')->group(function () {
        Route::get('/', [PropertyManagerController::class, 'index']);
        Route::post('/', [PropertyManagerController::class, 'store']);
        Route::get('/{id}', [PropertyManagerController::class, 'show']);
        Route::put('/{id}', [PropertyManagerController::class, 'update']);
        Route::delete('/{id}', [PropertyManagerController::class, 'destroy']);

        // Additional property manager routes
        Route::get('/active', [PropertyManagerController::class, 'getActiveManagers']);
        Route::get('/{id}/properties', [PropertyManagerController::class, 'getManagerProperties']);
        Route::post('/assign', [PropertyManagerController::class, 'assignProperties']);
        Route::put('/{id}/deactivate', [PropertyManagerController::class, 'deactivateManager']);
    });
});
