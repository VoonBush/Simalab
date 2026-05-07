@extends('layouts.user')
@section('title', 'Pinjam Barang — InventarisLab')
@section('page-title', 'Pinjam Barang')
@section('page-subtitle', 'Ajukan permintaan peminjaman barang laboratorium')

@section('content')
<div class="max-w-2xl mx-auto">
    {{-- Form --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <form method="POST" action="{{ route('peminjaman.store') }}" class="space-y-5">
            @csrf

            {{-- Barang Selection --}}
            <div>
                <label for="barang" class="block text-sm font-semibold text-slate-900 mb-2">Pilih Barang</label>
                <select name="id_barang" id="barang" required 
                    class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('id_barang') border-red-500 @enderror">
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id_barang }}" {{ old('id_barang') == $barang->id_barang || $selectedBarang?->id_barang == $barang->id_barang ? 'selected' : '' }}>
                            {{ $barang->nama_barang }} (Tersedia: {{ $barang->stok_tersedia }})
                        </option>
                    @endforeach
                </select>
                @error('id_barang')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jumlah --}}
            <div>
                <label for="jumlah" class="block text-sm font-semibold text-slate-900 mb-2">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" min="1" value="{{ old('jumlah', 1) }}" required
                    class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('jumlah') border-red-500 @enderror">
                @error('jumlah')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Peminjaman --}}
            <div>
                <label for="tanggal_peminjaman" class="block text-sm font-semibold text-slate-900 mb-2">Tanggal Peminjaman</label>
                <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman" value="{{ old('tanggal_peminjaman') }}" required
                    class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('tanggal_peminjaman') border-red-500 @enderror">
                @error('tanggal_peminjaman')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Durasi Peminjaman --}}
            <div>
                <label for="durasi_peminjaman" class="block text-sm font-semibold text-slate-900 mb-2">Durasi Peminjaman (Hari)</label>
                <input type="number" name="durasi_peminjaman" id="durasi_peminjaman" min="1" value="{{ old('durasi_peminjaman', 1) }}" required
                    class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('durasi_peminjaman') border-red-500 @enderror">
                @error('durasi_peminjaman')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Keterangan --}}
            <div>
                <label for="keterangan" class="block text-sm font-semibold text-slate-900 mb-2">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="4" placeholder="Jelaskan kebutuhan dan tujuan peminjaman barang..."
                    class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 @error('keterangan') border-red-500 @enderror">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors">
                    Ajukan Peminjaman
                </button>
                <a href="{{ route('user.barang') }}" class="flex-1 text-center py-3 text-sm font-semibold text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">
                    Kembali
                </a>
            </div>
        </form>
    </div>

    {{-- Info Box --}}
    <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 mt-6">
        <h3 class="font-semibold text-blue-900 mb-2">💡 Petunjuk Peminjaman</h3>
        <ul class="text-sm text-blue-800 space-y-1">
            <li>✓ Pastikan barang yang dibutuhkan tersedia sebelum mengajukan peminjaman</li>
            <li>✓ Permintaan peminjaman Anda akan diproses oleh petugas laboratorium</li>
            <li>✓ Anda akan menerima notifikasi melalui email ketika permintaan disetujui</li>
            <li>✓ Ikuti aturan penggunaan barang sesuai dengan prosedur laboratorium</li>
        </ul>
    </div>
</div>
@endsection
