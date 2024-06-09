<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\RaffleController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests as Precognition;

Route::namespace('admin')->prefix('admin')->group(function () {

    Route::get('login', [AdminController::class, 'login'])->name('admin.login');

    Route::post('/auth', [AdminController::class, 'auth'])->name('admin.auth');

    Route::middleware('admin')->group(function () {
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

        Route::get('/', [DashboardController::class, 'index'])->name('admin.index');
        Route::get('/criar-rifa', [RaffleController::class, 'create'])->name('create.raffle');
        Route::post('/salvar-rifa', [RaffleController::class, 'store'])->name('store.raffle')->middleware(Precognition::class);
        Route::post('/atualizar-rifa/{id}', [RaffleController::class, 'update'])->name('update.raffle')->middleware(Precognition::class);

        Route::get('/rifa/{id}', [RaffleController::class, 'raffle'])->name('admin.raffle');



        // apis
        Route::get('get-raffles', [ApiController::class, 'getRaffles']);
    });
});
