<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend (customer) routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [HomeController::class, 'menu'])->name('menu');
Route::get('/about', [HomeController::class, 'about'])->name('about');

Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/reservation', [ReservationController::class, 'create'])->name('reservation');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{food}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{food}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{food}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/order/success/{order:order_number}', [CheckoutController::class, 'success'])->name('order.success');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/my-account', [AccountController::class, 'index'])->name('account');
    Route::get('/my-orders/{order:order_number}', [AccountController::class, 'order'])->name('account.order');
});

/*
|--------------------------------------------------------------------------
| Admin panel routes  (/admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', Admin\CategoryController::class)->except('show');
    Route::resource('foods', Admin\FoodController::class)->except('show');

    Route::get('orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('orders.status');
    Route::delete('orders/{order}', [Admin\OrderController::class, 'destroy'])->name('orders.destroy');

    Route::get('reservations', [Admin\ReservationController::class, 'index'])->name('reservations.index');
    Route::patch('reservations/{reservation}/status', [Admin\ReservationController::class, 'updateStatus'])->name('reservations.status');
    Route::delete('reservations/{reservation}', [Admin\ReservationController::class, 'destroy'])->name('reservations.destroy');

    Route::get('messages', [Admin\MessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{contact}', [Admin\MessageController::class, 'show'])->name('messages.show');
    Route::delete('messages/{contact}', [Admin\MessageController::class, 'destroy'])->name('messages.destroy');

    Route::get('users', [Admin\UserController::class, 'index'])->name('users.index');
});
