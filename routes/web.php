<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PizzaController;
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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/cart', [PizzaController::class, 'showCart'])->name('cart');
    Route::get('/checkout/cod', [PizzaController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/card/{totalprice}/{receiverName}/{receiverNumber}', [PizzaController::class, 'cardCheckout'])->name('card.checkout');


    Route::post('/checkout/card/payment', [PizzaController::class, 'cardPayment'])->name('card.payment');

    Route::get('/orders', [PizzaController::class, 'orders'])->name('user.orders');
    
});


Route::middleware(['auth', 'Admin_auth'])->group(function() {
    Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/order/history', [AdminController::class, 'OrderHistory'])->name('admin.orders.history');
});
