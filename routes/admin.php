<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\RaffleController;

Route::namespace('admin')->prefix('admin')->group(function () {

    Route::get('login', [AdminController::class, 'login'])->name('admin.login');

    Route::post('/auth', [AdminController::class, 'auth'])->name('admin.auth');

    Route::middleware('admin')->group(function () {
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

        Route::get('/', [DashboardController::class, 'index'])->name('admin.index');

        Route::post('/criar-rifa', [RaffleController::class, 'create'])->name('raffle.create');
    });
});
