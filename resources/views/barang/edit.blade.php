@extends('layouts.admin')
@section('title', 'Edit Barang — InventarisLab')
@section('page-title', 'Edit Data Barang')
@section('page-subtitle', 'Perbarui informasi barang inventaris')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <form method="POST" action="{{ route('barang.update', $barang) }}" class="p-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Kode Barang</label>
                    <input type="text" value="{{ $barang->kode_barang }}" readonly class="w-full px-4 py-2.5 rounded-xl border border-slate-100 bg-slate-50 text-slate-500 cursor-not-allowed">
                    <p class="mt-1 text-[10px] text-slate-400">Kode barang tidak dapat diubah untuk menjaga integritas data.</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Barang</label>
                    <input type="text" name="nama_barang" value="{{ old('nama_barang', $barang->nama_barang) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    @error('nama_barang') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Stok Total</label>
                        <input type="number" name="stok_total" min="0" value="{{ old('stok_total', $barang->stok_total) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        @error('stok_total') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Stok Tersedia</label>
                        <input type="number" name="stok_tersedia" min="0" value="{{ old('stok_tersedia', $barang->stok_tersedia) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        @error('stok_tersedia') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Kondisi</label>
                        <select name="kondisi" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="Normal" {{ old('kondisi', $barang->kondisi) == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Rusak" {{ old('kondisi', $barang->kondisi) == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                            <option value="Error" {{ old('kondisi', $barang->kondisi) == 'Error' ? 'selected' : '' }}>Error</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Lokasi</label>
                        <input type="text" name="lokasi" value="{{ old('lokasi', $barang->lokasi) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        @error('lokasi') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-8 flex items-center justify-end gap-3">
                <a href="{{ route('barang.index') }}" class="px-6 py-2.5 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-50 transition-all">Batal</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-500/20 transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
