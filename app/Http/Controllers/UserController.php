<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
{
    $user = Auth::user();
    // Gunakan $user->id_user karena itu nama kolom di migrasi Anda
    $totalPinjam = Peminjaman::where('id_user', $user->id_user)->count();
    $totalProses = Peminjaman::where('id_user', $user->id_user)
                    ->where('status', 'diajukan')
                    ->count();
    
    $peminjamans = Peminjaman::with('details.barang')
                    ->where('id_user', $user->id_user)
                    ->latest()
                    ->take(5)
                    ->get();

    return view('user.dashboard', compact('totalPinjam', 'totalProses', 'peminjamans'));
}

    public function barang(Request $request)
    {
        $query = Barang::query();
        if ($request->has('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%');
        }
        $barangs = $query->paginate(9);
        return view('user.barang', compact('barangs'));
    }

    public function ketersediaan(Request $request)
    {
        $kategori = $request->get('kategori', 'semua');
        $kategoriList = Barang::select('kategori')->distinct()->pluck('kategori');
        
        $query = Barang::query();
        if ($kategori !== 'semua') {
            $query->where('kategori', $kategori);
        }
        
        $barangs = $query->paginate(12);
        return view('user.ketersediaan', compact('barangs', 'kategori', 'kategoriList'));
    }

    public function pinjam(Request $request)
    {
        $barangs = Barang::where('stok_tersedia', '>', 0)->get();
        $selectedBarang = null;
        if ($request->has('barang_id')) {
            $selectedBarang = Barang::find($request->barang_id);
        }
        return view('user.pinjam', compact('barangs', 'selectedBarang'));
    }

    public function riwayat(Request $request)
    {
        $status = $request->get('status', 'semua');
        $statusList = ['diajukan', 'disetujui', 'dikembalikan', 'ditolak'];
        
        $query = Peminjaman::with('details.barang')->where('id_user', Auth::id());
        if ($status !== 'semua') {
            $query->where('status', $status);
        }
        
        $peminjamans = $query->latest()->paginate(10);
        return view('user.riwayat', compact('peminjamans', 'status', 'statusList'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}