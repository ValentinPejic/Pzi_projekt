<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;


// Ruta za početnu stranicu
Route::get('/', [ProductController::class, 'index'])->name('home');

// Ruta za stranicu za prijavu (GET zahtjev)
Route::view('/login', 'login')->name('login');

// Ruta za obradu prijave (POST zahtjev)
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Ruta za stranicu za registraciju (GET zahtjev)
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Ruta za obradu registracijskog obrasca (POST zahtjev)
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Ruta za stranicu s košaricom
Route::get('/cart', [CartController::class, 'index'])->name('cart');

// Ruta za prikaz narudžbi korisnika
Route::get('/my-orders', [OrderController::class, 'showOrders'])->name('orders.show')->middleware('auth');


// Ruta za dodavanje stavki u košaricu
Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');

// Ruta za ažuriranje količine u košarici
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

// Ruta za uklanjanje stavki iz košarice
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Ruta za postavljanje narudžbe
Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place');

// Opcionalno: Ako želite imati rute za kreiranje, uređivanje i brisanje proizvoda
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');


// Ruta za odjavu (POST zahtjev)
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // Preusmjerava na početnu stranicu nakon odjave
})->name('logout');
