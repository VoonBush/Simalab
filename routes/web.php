<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\BarangController;

Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        if (in_array($role, ['admin', 'koordinator_lab', 'asisten'])) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return redirect('/');
})->name('dashboard');

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
    Route::middleware(['role:admin,koor_lab,asisten'])->prefix('admin')->group(function () {
        Route::name('admin.')->group(function () {
            Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
            
            // Role Management (restricted in controller to admin & koor_lab)
            Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
            Route::patch('/users/{user}/role', [\App\Http\Controllers\AdminController::class, 'updateRole'])->name('users.updateRole');
            
            // Peminjaman Status Update
            Route::patch('/peminjaman/{id}/status', [PeminjamanController::class, 'updateStatus'])->name('peminjaman.updateStatus');
        });

        // Barang Management (Keep original names like 'barang.index')
        Route::resource('barang', BarangController::class);
    });
});

require __DIR__.'/auth.php';