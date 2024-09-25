<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WholesaleOrderController;


use App\Models\Carscent;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/shop', function () {
    return view('shop');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/payment', function () {
//     return view('payment');
// })->middleware(['auth', 'verified'])->name('payment');
// Route::get('/shop', function () {
//     return view('shop');
// })->middleware(['auth', 'verified'])->name('shop');
// Route::get('/shop', [CandleController::class, 'index'])
//     ->middleware(['auth', 'verified'])
//     ->name('shop');
Route::get('/shop', [ProductController::class, 'index'])
->middleware(['auth', 'verified'])
->name('shop');


Route::get('/scent', function () {
    return view('scent');
})->middleware(['auth', 'verified'])->name('scent');

Route::get('/wholesale', function () {
    return view('wholesale');
})->middleware(['auth', 'verified'])->name('wholesale');

Route::get('/cart', function () {
    return view('cart');
})->middleware(['auth', 'verified'])->name('cart');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//cart
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::post('/cart/delete', [CartController::class, 'deleteFromCart'])->name('cart.delete');
Route::get('/cart/total', [CartController::class, 'cartTotal'])->name('cart.total');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart');
//checkout
Route::post('/submit', [CheckoutController::class, 'submit'])->name('submit');
Route::get('/checkout', function () {
    return view('checkout');
})->middleware(['auth', 'verified'])->name('checkout');
//payment
 Route::get('/payment', [PaymentController::class, 'showPaymentPage'])->name('payment');
Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');
 Route::get('/success', [PaymentController::class, 'paymentSuccess'])->name('success');
Route::post('/payment/callback', [PaymentController::class, 'handleCallback'])->name('payment.callback');
 Route::post('/payment/confirm', [PaymentController::class, 'confirmPayment'])->name('payment.confirm');

 Route::get('/payment/success', function () {
    return view('success'); // Point to your success view
})->name('payment.success');

//wholesale 
Route::post('/wholesale', [WholesaleOrderController::class, 'store'])->name('wholesale.store');



require __DIR__.'/auth.php';
