<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DepartmentController;

/**
 * Region Routes
 */
Route::prefix('regions')->controller(RegionController::class)->group(function () {
    Route::get('/', 'getRegionList');
    Route::post('/', 'createRegion');

    Route::prefix('{region}')->group(function() {
        Route::get('/', 'getRegion');
        Route::put('/', 'updateRegion');
        Route::delete('/', 'deleteRegion');
    });
});

/**
 * Country Routes
 */
Route::prefix('countries')->controller(CountryController::class)->group(function () {
    Route::get('/', 'getCountryList');
    Route::post('/', 'createCountry');

    Route::prefix('{country}')->group(function() {
        Route::get('/', 'getCountry');
        Route::put('/', 'updateCountry');
        Route::delete('/', 'deleteCountry');
    });
});

/**
 * Company Routes
 */
Route::prefix('companies')->controller(CompanyController::class)->group(function () {
    Route::get('/', 'getCompanyList');
    Route::post('/', 'createCompany');

    Route::prefix('{company}')->group(function() {
        Route::get('/', 'getCompany');
        Route::put('/', 'updateCompany');
        Route::delete('/', 'deleteCompany');
    });
});

/**
 * Department Routes
 */
Route::prefix('departments')->controller(DepartmentController::class)->group(function () {
    Route::get('/', 'getDepartmentList');
    Route::post('/', 'createDepartment');

    Route::prefix('{department}')->group(function() {
        Route::get('/', 'getDepartment');
        Route::put('/', 'updateDepartment');
        Route::delete('/', 'deleteDepartment');
    });
});

/**
 * Team Routes
 */
Route::prefix('teams')->controller(TeamController::class)->group(function () {
    Route::get('/', 'getTeamList');
    Route::post('/', 'createTeam');

    Route::prefix('{team}')->group(function() {
        Route::get('/', 'getTeam');
        Route::put('/', 'updateTeam');
        Route::delete('/', 'deleteTeam');
    });
});