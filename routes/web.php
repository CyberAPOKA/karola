<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RaffleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Rotas admin
require(base_path('routes/admin.php'));

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/', [HomeController::class, 'home'])->name('home');
    Route::get('rifa/{id}', [RaffleController::class, 'raffle'])->name('raffle');

    // Cria um pedido com o id da rifa.
    Route::post('criar-pedido/{id}', [OrderController::class, 'createOrder'])->name('create.order');

    // Retorna
    Route::get('pagamento/{id}', [OrderController::class, 'payment'])->name('payment');

    //Pagamento final
    Route::post('confirmar-pagamento/{id}', [PaymentController::class, 'confirmPayment'])->name('confirm.payment');

    Route::post('/orders/{order}/simulate-payment', [PaymentController::class, 'simulatePayment']);

});
