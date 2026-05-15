@extends('layouts.admin')
@section('title', 'Daftar Barang — InventarisLab')
@section('page-title', 'Manajemen Inventaris')
@section('page-subtitle', 'Daftar seluruh barang yang tersedia di laboratorium')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h3 class="text-lg font-bold text-slate-800">Daftar Barang</h3>
    <a href="{{ route('barang.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-semibold shadow-lg shadow-indigo-500/20 transition-all flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Barang
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">Kode</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">Nama Barang</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">Stok (Tersedia/Total)</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">Lokasi</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">Kondisi</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider border-b border-slate-100">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($barangs as $barang)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 font-medium text-slate-700">{{ $barang->kode_barang }}</td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-slate-900">{{ $barang->nama_barang }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <span class="font-bold {{ $barang->stok_tersedia > 0 ? 'text-emerald-600' : 'text-red-600' }}">
                                {{ $barang->stok_tersedia }}
                            </span>
                            <span class="text-slate-400 text-xs">/ {{ $barang->stok_total }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600">{{ $barang->lokasi }}</td>
                    <td class="px-6 py-4">
                        <span @class([
                            'px-2 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider',
                            'bg-emerald-100 text-emerald-700' => $barang->kondisi == 'Normal',
                            'bg-red-100 text-red-700' => $barang->kondisi == 'Rusak',
                            'bg-amber-100 text-amber-700' => !in_array($barang->kondisi, ['Normal', 'Rusak']),
                        ])>
                            {{ $barang->kondisi }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('barang.edit', $barang) }}" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.138 6.638a2.25 2.25 0 113.182 3.182L10 20H7v-3L16.138 6.638z"/></svg>
                            </a>
                            <form action="{{ route('barang.destroy', $barang) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
