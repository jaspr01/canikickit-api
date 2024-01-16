<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Clients
    Route::resource('clients', ClientController::class)->except(['create', 'edit']);

    // Companies
    Route::resource('companies', CompanyController::class)->except(['create', 'edit']);

    // Users
    Route::prefix('user')->controller(UserController::class)->group(function () {
        Route::get('/', 'get');
        Route::get('/{id}', 'getById');
    });
});
