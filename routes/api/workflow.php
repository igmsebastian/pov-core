<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\FeatureController;

/**
 * Module Routes
 */
Route::prefix('modules')
    ->middleware(['auth:sanctum', 'module:admin'])
    ->controller(ModuleController::class)
    ->group(function () {
        Route::get('/', 'getModuleList');
        Route::get('init-data', 'getInit');

        Route::post('/', 'createModule');

        Route::delete('/', 'deleteModules');
        Route::patch('change-status', 'updateModuleStatus');

        // @url: api/modules/{id}
        Route::prefix('{module}')->group(function () {
            Route::get('/', 'getModule');
            Route::put('/', 'updateModule');
        });
    });

/**
 * Feature Routes
 */
Route::prefix('features')
    ->middleware(['auth:sanctum', 'module:admin'])
    ->controller(FeatureController::class)
    ->group(function () {
        Route::get('/', 'getFeatureList');
        Route::get('init-data', 'getInit');

        Route::post('/', 'createFeature');

        Route::delete('/', 'deleteFeatures');
        Route::patch('change-status', 'updateFeatureStatus');

        // @url: api/features/{id}
        Route::prefix('{feature}')->group(function () {
            Route::get('/', 'getFeature');
            Route::put('/', 'updateFeature');
        });
    });
