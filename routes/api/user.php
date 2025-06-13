<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/**
 * User Routes
 */
Route::prefix('users')
    ->middleware(['auth:sanctum', 'module:user'])
    ->controller(UserController::class)
    ->group(function () {
    Route::get('/', 'getUserList');
    Route::get('init-data', 'getInit');

    Route::post('/', 'createUser');

    Route::delete('/', 'deleteUsers');
    Route::patch('change-status', 'updateUserStatus');

    // @url: api/users/{id}
    Route::prefix('{user}')->group(function() {
        Route::get('/', 'getUser');
        Route::put('/', 'updateUser');
    });
});
