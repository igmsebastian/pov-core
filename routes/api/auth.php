<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

/**
 * Authentication Routes
 */
Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('access-token', 'getAccessToken');
    Route::get('me', 'getAuthenticatedUser');
});

/**
 * Permissions Routes
 */
Route::prefix('permissions')->controller(PermissionController::class)->group(function () {
    Route::get('/', 'getPermissions');
    Route::post('/', 'createPermission');

    Route::prefix('{permission}')->group(function() {
        Route::get('/', 'getPermission');
        Route::post('/', 'updatePermission');
        Route::put('/', 'updatePermission');
        Route::delete('/', 'deletePermission');
    });
});

/**
 * Roles Routes
 */
Route::prefix('roles')->controller(RoleController::class)->group(function () {
    Route::get('/', 'getRoles');
    Route::post('/', 'createRole');

    Route::prefix('{role}')->group(function() {
        Route::get('/', 'getRole');
        Route::put('/', 'updateRole');
        Route::delete('/', 'deleteRole');
    });
});