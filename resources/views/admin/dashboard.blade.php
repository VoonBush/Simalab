@extends('layouts.admin')
@section('title', 'Dashboard Admin — InventarisLab')
@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Pantau aktivitas laboratorium hari ini')

@section('content')
{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
            </div>
            <div>
                <p class="text-sm text-slate-500 font-medium">Total Barang</p>
                <h3 class="text-2xl font-bold text-slate-900">{{ $totalBarang }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-amber-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-sm text-slate-500 font-medium">Persetujuan Tertunda</p>
                <h3 class="text-2xl font-bold text-slate-900">{{ $pendingPeminjaman }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            </div>
            <div>
                <p class="text-sm text-slate-500 font-medium">Total Transaksi</p>
                <h3 class="text-2xl font-bold text-slate-900">{{ $totalPeminjaman }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- Pending Approvals --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
        <h3 class="font-bold text-slate-900">Daftar Pengajuan Peminjaman</h3>
        <span class="px-3 py-1 bg-amber-50 text-amber-700 text-xs font-bold rounded-full border border-amber-100">
            Perlu Tindakan
        </span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">Mahasiswa</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">Barang</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">Tanggal Pinjam</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($peminjamans as $peminjaman)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-900">{{ $peminjaman->user->nama }}</p>
                        <p class="text-xs text-slate-500">{{ $peminjaman->user->npm }}</p>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        @foreach($peminjaman->details as $detail)
                            <span class="inline-block px-2 py-0.5 bg-slate-100 rounded text-xs mr-1 mb-1">
                                {{ $detail->barang->nama_barang }} ({{ $detail->jumlah }})
                            </span>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">
                        {{ $peminjaman->tanggal_pinjam->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider
                            @if($peminjaman->status == 'diajukan') bg-amber-100 text-amber-700
                            @elseif($peminjaman->status == 'disetujui') bg-indigo-100 text-indigo-700
                            @elseif($peminjaman->status == 'ditolak') bg-red-100 text-red-700
                            @else bg-slate-100 text-slate-700
                            @endif">
                            {{ $peminjaman->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($peminjaman->status == 'diajukan')
                        <div class="flex gap-2">
                            <form action="{{ route('admin.peminjaman.updateStatus', $peminjaman->id_peminjaman) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="disetujui">
                                <button type="submit" class="p-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white rounded-lg transition-all border border-emerald-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </form>
                            <form action="{{ route('admin.peminjaman.updateStatus', $peminjaman->id_peminjaman) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="ditolak">
                                <button type="submit" class="p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg transition-all border border-red-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </form>
                        </div>
                        @else
                        <span class="text-xs text-slate-400 italic">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                        <p>Tidak ada pengajuan peminjaman saat ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($peminjamans->hasPages())
    <div class="p-6 border-t border-slate-100">
        {{ $peminjamans->links() }}
    </div>
    @endif
</div>
@endsection
