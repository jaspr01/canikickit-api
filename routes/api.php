<?php

use App\Http\Controllers\AuthController;
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

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    // GET
    Route::get('email/verify/{id}/{hash}', 'verify')->name('verification.verify');

    // POST
    Route::post('login', 'login');
    Route::post('register', 'register');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        // GET
        Route::get('logout', 'logout');
    });
    // TODO: Add verify email, reset password, refresh token & logout routes

    Route::prefix('user')->controller(UserController::class)->group(function () {
        Route::get('/', 'get');
    });
});
