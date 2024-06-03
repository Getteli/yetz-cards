<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;

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

// LOGIN VIA API
Route::middleware('guest')->group(function () {
    Route::post('register', [RegisteredUserController::class, 'apistore']);

    Route::post('login', [AuthenticatedSessionController::class, 'apistore']);

    Route::post('forgot-password', [PasswordResetLinkController::class, 'apistore']);

    Route::post('reset-password', [NewPasswordController::class, 'apistore']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'apistore']);
    Route::put('password', [PasswordController::class, 'apiupdate']);
    Route::post('logout', [AuthenticatedSessionController::class, 'apidestroy']);

    Route::get('/profile', [ProfileController::class, 'apiProfile']);
    Route::post('/profile', [ProfileController::class, 'apiUpdate']);
    Route::delete('/profile', [ProfileController::class, 'apiDestroy']);

    // TEAM
    Route::get('/team/list', [TeamController::class, 'apiIndex']);
    Route::get('/team/{id}', [TeamController::class, 'apiOpen']);
    Route::post('/team/edit', [TeamController::class, 'apiUpdate']);
    // organizar partida
    Route::post('/team/create', [TeamController::class, 'apiCreate']);
    Route::delete('/team/delete/{id}', [TeamController::class, 'apiDelete']);

    // USER
    Route::get('/player/list', [PlayerController::class, 'apiIndex']);
    Route::get('/player/{id}', [PlayerController::class, 'apiOpen']);
    Route::post('/player/edit', [PlayerController::class, 'apiUpdate']);
    Route::post('/player/create', [PlayerController::class, 'apiCreate']);
    Route::delete('/player/delete/{id}', [PlayerController::class, 'apiDelete']);

    // LOG TEAM
    Route::get('/resultados/list', [LogTeamController::class, 'apiIndex']);
    Route::post('/resultados/create', [LogTeamController::class, 'apiCreate']);
});