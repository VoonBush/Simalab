<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ModuleController;

// Root redirect berdasarkan role
Route::get('/', function () {
    if (!auth()->check()) return redirect()->route('login');

    $user = auth()->user();
    if ($user->hasRole(['asisten_lab', 'pj'])) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('katalog');
})->name('home');

Route::get('/dashboard', fn() => redirect('/'))->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // ─── Mahasiswa / Umum ─────────────────────────────────────────
    Route::get('/katalog', function () {
        $items     = \App\Models\Item::with('location')->paginate(12);
        $locations = \App\Models\Location::all();
        return view('katalog', compact('items', 'locations'));
    })->name('katalog');

    // Borrowings (mahasiswa bisa buat, staff bisa manage)
    Route::resource('borrowings', BorrowingController::class)
        ->only(['index', 'create', 'store', 'show']);

    Route::patch('/borrowings/{borrowing}/approve', [BorrowingController::class, 'approve'])
        ->name('borrowings.approve')
        ->middleware('role:asisten_lab|pj');

    Route::patch('/borrowings/{borrowing}/reject', [BorrowingController::class, 'reject'])
        ->name('borrowings.reject')
        ->middleware('role:asisten_lab|pj');

    Route::patch('/borrowings/{borrowing}/returned', [BorrowingController::class, 'markReturned'])
        ->name('borrowings.returned')
        ->middleware('role:asisten_lab|pj');

    // Modules
    Route::resource('modules', ModuleController::class)
        ->only(['index', 'show', 'create', 'store', 'destroy']);

    // ─── Admin / Staff Area ───────────────────────────────────────
    Route::middleware(['role:asisten_lab|pj'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // Dashboard Asisten/Admin
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

            // Item (Barang) Management
            Route::resource('items', ItemController::class);

            // User Management (PLP & Koordinator only)
            Route::get('/users', [AdminController::class, 'users'])->name('users');
            Route::patch('/users/{user}/role', [AdminController::class, 'updateRole'])->name('users.updateRole');
        });

    // Profile
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';