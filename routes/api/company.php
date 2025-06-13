<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DepartmentController;

/**
 * Company Routes
 */
// Route::prefix('companies')->controller(CompanyController::class)->group(function () {
//     Route::get('/', 'getCompanyList');
//     Route::post('/', 'createCompany');

//     Route::prefix('{company}')->group(function() {
//         Route::get('/', 'getCompany');
//         Route::put('/', 'updateCompany');
//         Route::delete('/', 'deleteCompany');
//     });
// });

/**
 * Department Routes
 */
// Route::prefix('departments')->controller(DepartmentController::class)->group(function () {
//     Route::get('/', 'getDepartmentList');
//     Route::post('/', 'createDepartment');

//     Route::prefix('{department}')->group(function() {
//         Route::get('/', 'getDepartment');
//         Route::put('/', 'updateDepartment');
//         Route::delete('/', 'deleteDepartment');
//     });
// });

/**
 * Team Routes
 */
// Route::prefix('teams')->controller(TeamController::class)->group(function () {
//     Route::get('/', 'getTeamList');
//     Route::post('/', 'createTeam');

//     Route::prefix('{team}')->group(function() {
//         Route::get('/', 'getTeam');
//         Route::put('/', 'updateTeam');
//         Route::delete('/', 'deleteTeam');
//     });
// });
