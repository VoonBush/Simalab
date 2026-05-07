<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\BarangController;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('user.dashboard') : redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    
    // User Menu (Prefix 'user')
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('/barang', [UserController::class, 'barang'])->name('barang');
        Route::get('/ketersediaan', [UserController::class, 'ketersediaan'])->name('ketersediaan');
        Route::get('/pinjam', [UserController::class, 'pinjam'])->name('pinjam');
        Route::get('/riwayat', [UserController::class, 'riwayat'])->name('riwayat');
        Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    });

    // Peminjaman Logic
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    
    // Admin & Staff Area
    Route::middleware(['role:admin,koor_lab,asisten'])->group(function () {
        Route::resource('barang', BarangController::class)->except(['index']);
        Route::patch('/peminjaman/{id}/status', [PeminjamanController::class, 'updateStatus'])->name('peminjaman.updateStatus');
    });
});

require __DIR__.'/auth.php';