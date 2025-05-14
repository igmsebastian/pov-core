<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

/**
 * User Routes
 *
 */
Route::prefix('users')->controller(UserController::class)->group(function () {
    Route::get('/', 'getUserList');
    Route::post('/', 'createUser');

    Route::prefix('{user}')->group(function() {
        Route::get('/', 'getUser');
        Route::post('/', 'updateUser');

        Route::prefix('permissions')->group(function() {
            Route::get('/', 'getPermissions');
            Route::post('/', 'updatePermissions');
        });
    });
});