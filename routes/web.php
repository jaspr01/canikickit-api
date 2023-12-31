<?php

use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('email/verify/{id}/{hash}', 'verify')->name('verification.verify');
    Route::post('login', 'login');
    Route::post('logout', 'logout');
    Route::post('register', 'register');
});
