<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdminAuthController;

// ==================== ADMIN AUTH ====================
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ==================== CUSTOMER AREA ====================
Route::get('/Daharane', [CustomerController::class, 'landing'])->name('customer.landing');
Route::get('/daftarmenu', [CustomerController::class, 'menu'])->name('customer.menu');
Route::get('/daftarmenu/search', [CustomerController::class, 'search'])->name('customer.search');
Route::get('/daftarmenu/makanan', [CustomerController::class, 'makanan'])->name('customer.menu.makanan');
Route::get('/daftarmenu/minuman', [CustomerController::class, 'minuman'])->name('customer.menu.minuman');
Route::get('/daftarmenu/makanan-ringan', [CustomerController::class, 'makananRingan'])->name('customer.menu.makanan-ringan');
Route::get('/daftarmenu/makanan-penutup', [CustomerController::class, 'makananPenutup'])->name('customer.menu.makanan-penutup');
Route::get('/kategori/{id}', [CustomerController::class, 'kategori'])->name('customer.kategori');

Route::get('/keranjang', [CustomerController::class, 'showCart'])->name('customer.cart');
Route::post('/keranjang/tambah/{id}', [CustomerController::class, 'addToCart'])->name('customer.cart.add');
Route::post('/keranjang/update', [CustomerController::class, 'updateCart'])->name('customer.cart.update');
Route::post('/order/store', [CustomerController::class, 'storeOrder'])->name('order.store');

Route::get('/bill/{order}', [CustomerController::class, 'bill'])->name('customer.bill');
Route::get('/logo-redirect', [CustomerController::class, 'logoRedirect'])->name('customer.logoRedirect');

// ==================== ADMIN AREA (Protected by Middleware) ====================
Route::middleware('admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('menu.index');
    });

    Route::get('/dashboard', [MenuController::class, 'dashboard'])->name('dashboard');
    Route::resource('menu', MenuController::class);

    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

    Route::get('/order/all', [MenuController::class, 'allOrders'])->name('detailpesanan');

    Route::get('/order/{id}/konfirmasi-pembayaran', [MenuController::class, 'showKonfirmasiPembayaran'])->name('konfirmasi.pembayaran');
    Route::post('/order/{id}/konfirmasi-pembayaran', [MenuController::class, 'prosesKonfirmasiPembayaran'])->name('konfirmasi.pembayaran.proses');

    Route::get('/order/{id}/konfirmasi-selesai', [MenuController::class, 'showKonfirmasiSelesai'])->name('konfirmasi.selesai');
    Route::post('/order/{id}/konfirmasi-selesai', [MenuController::class, 'prosesKonfirmasiSelesai'])->name('konfirmasi.selesai.proses');

    Route::get('/order/{id}/riwayat', [MenuController::class, 'riwayatPesanan'])->name('riwayat.pesanan');

    Route::post('/pesanan/{id}/konfirmasi-pembayaran', [MenuController::class, 'prosesKonfirmasiPembayaran'])
        ->name('proses.konfirmasi.pembayaran');

    Route::post('/pesanan/{id}/konfirmasi-selesai', [MenuController::class, 'prosesKonfirmasiSelesai'])
        ->name('proses.konfirmasi.selesai');

    Route::get('/pesanan/{id}/riwayat', [MenuController::class, 'riwayatPesanan'])
        ->name('riwayat.pesanan');
});
