<?php

use Illuminate\Http\Request;
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

Route::middleware(['treblle'])->group(function () {
    Route::prefix('v2')->group(function () {

        Route::post('/auth/register',[\App\Http\Controllers\v1\AuthController::class, 'register']);
        Route::post('/auth/login',[\App\Http\Controllers\v1\AuthController::class, 'login']);

        Route::get('/auth/email/verify/{id}/{hash}',[\App\Http\Controllers\v1\AuthController::class, 'verifyEmail'])
            ->middleware([])->name('verification.verify');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/auth/email/send',[\App\Http\Controllers\v1\AuthController::class, 'sendVerificationEmail']);

            Route::get('/user', [\App\Http\Controllers\v1\UserController::class, 'show']);
        });

        Route::prefix('admin')->group(function () {
            Route::post('/auth/login', [\App\Http\Controllers\v1\Admin\AuthController::class, 'login']);


            Route::middleware(['auth:sanctum', 'admin'])->group(function () {
                Route::get('/user', [\App\Http\Controllers\v1\Admin\UserController::class, 'show']);
            });
        });
    });
});
