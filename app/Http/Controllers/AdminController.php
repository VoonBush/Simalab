<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalBarang = \App\Models\Barang::count();
        $totalPeminjaman = Peminjaman::count();
        $pendingPeminjaman = Peminjaman::where('status', 'diajukan')->count();
        
        // Fetch all peminjaman requests, showing latest first
        $peminjamans = Peminjaman::with(['user', 'details.barang'])->latest()->paginate(10);
        
        return view('admin.dashboard', compact('totalBarang', 'totalPeminjaman', 'pendingPeminjaman', 'peminjamans'));
    }

    public function users()
    {
        // View accessible by admin and koor_lab
        if (!in_array(auth()->user()->role, ['admin', 'koordinator_lab'])) {
            abort(403, 'Unauthorized action.');
        }

        $users = User::where('id_user', '!=', auth()->id())->get();
        return view('admin.users', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        // Only admin and koor_lab can update roles
        if (!in_array(auth()->user()->role, ['admin', 'koordinator_lab'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'role' => 'required|in:admin,koordinator_lab,asisten,mahasiswa'
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'Role pengguna berhasil diperbarui.');
    }
}
