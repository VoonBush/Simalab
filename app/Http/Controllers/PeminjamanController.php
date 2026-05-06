<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        if (in_array(auth()->user()->role, ['admin', 'koor_lab', 'asisten'])) {
            $peminjamans = Peminjaman::with(['user', 'details.barang'])->latest()->get();
        } else {
            $peminjamans = Peminjaman::with(['details.barang'])->where('id_user', auth()->user()->id_user)->latest()->get();
        }
        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $barangs = Barang::where('stok_tersedia', '>', 0)->get();
        return view('peminjaman.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_barang' => 'required|exists:barang,id_barang',
            'jumlah' => 'required|integer|min:1',
            'batas_peminjaman' => 'required|date|after:today'
        ]);

        $barang = Barang::findOrFail($request->id_barang);

        if ($request->jumlah > $barang->stok_tersedia) {
            return back()->withErrors(['jumlah' => 'Jumlah melebihi stok yang tersedia.'])->withInput();
        }

        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::create([
                'id_user' => auth()->user()->id_user,
                'tanggal_pinjam' => now(),
                'batas_peminjaman' => $request->batas_peminjaman,
                'status' => 'diajukan'
            ]);

            DetailPeminjaman::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_barang' => $barang->id_barang,
                'jumlah' => $request->jumlah,
                'kondisi_keluar' => 'Normal'
            ]);

            DB::commit();
            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diajukan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak,dikembalikan'
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        
        DB::beginTransaction();
        try {
            if ($request->status == 'disetujui' && $peminjaman->status == 'diajukan') {
                foreach ($peminjaman->details as $detail) {
                    $barang = $detail->barang;
                    if ($barang->stok_tersedia < $detail->jumlah) {
                        throw new \Exception("Stok {$barang->nama_barang} tidak mencukupi.");
                    }
                    $barang->decrement('stok_tersedia', $detail->jumlah);
                }
            } elseif ($request->status == 'dikembalikan' && $peminjaman->status == 'disetujui') {
                foreach ($peminjaman->details as $detail) {
                    $detail->barang->increment('stok_tersedia', $detail->jumlah);
                }
                $peminjaman->tanggal_kembali = now();
            } elseif ($request->status == 'ditolak' && $peminjaman->status == 'disetujui') {
                 // Prevent tolak if already disetujui (for simplicity)
                 throw new \Exception("Tidak bisa menolak peminjaman yang sudah disetujui.");
            }

            $peminjaman->status = $request->status;
            $peminjaman->save();

            DB::commit();
            return redirect()->route('peminjaman.index')->with('success', 'Status peminjaman diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
