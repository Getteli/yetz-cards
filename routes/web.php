<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [IndexController::class, 'home'])->name('home');

Route::middleware('auth')->group(function ()
{
    Route::get('/dashboard', [IndexController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // TEAM
    Route::get('/team/list', [TeamController::class, 'index'])->name('team.list');
    Route::get('/team/{id}', [TeamController::class, 'open'])->name('team.open');
    Route::patch('/team/edit', [TeamController::class, 'update'])->name('team.edit');
    Route::patch('/team/create', [TeamController::class, 'create'])->name('team.create');

    // USER
    Route::get('/player/list', [PlayerController::class, 'index'])->name('player.list');
    Route::get('/player/form', [PlayerController::class, 'form'])->name('player.form');
    Route::get('/player/{id}', [PlayerController::class, 'open'])->name('player.open');
    Route::patch('/player/edit', [PlayerController::class, 'update'])->name('player.update');
    Route::patch('/player/create', [PlayerController::class, 'create'])->name('player.create');
    Route::delete('/player/delete/{id}', [PlayerController::class, 'delete'])->name('player.delete');
});

require __DIR__.'/auth.php';