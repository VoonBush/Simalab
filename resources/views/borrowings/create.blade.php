@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')
@section('page-title', 'Form Peminjaman Barang')
@section('page-subtitle', 'Lengkapi data untuk mengajukan peminjaman alat lab.')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- Item Preview Header --}}
        <div class="p-6 bg-blue-600 flex items-center gap-4">
            <img src="{{ $item->image_url }}" alt="" class="w-16 h-16 rounded-xl object-cover border-2 border-white/20 bg-white/10"
                 onerror="this.src='https://placehold.co/100x100/3b82f6/ffffff?text=IMG'">
            <div class="flex-1 min-w-0">
                <p class="text-blue-100 text-xs font-bold uppercase tracking-wider mb-0.5">Meminjam Barang:</p>
                <h3 class="text-white font-bold truncate">{{ $item->name }}</h3>
                <p class="text-blue-200 text-xs">Stok Tersedia: {{ $item->available_stock }} unit</p>
            </div>
        </div>

        <form action="{{ route('borrowings.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            <input type="hidden" name="item_id" value="{{ $item->id }}">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- Jumlah --}}
                <div class="sm:col-span-2">
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Pinjam</label>
                    <input type="number" name="quantity" id="quantity" required min="1" max="{{ $item->available_stock }}"
                           value="{{ old('quantity', 1) }}"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                    <p class="mt-1 text-[10px] text-gray-400 font-medium">Maksimal: {{ $item->available_stock }} unit</p>
                    <x-input-error :messages="$errors->get('quantity')" class="mt-1" />
                </div>

                {{-- Tanggal Pinjam --}}
                <div>
                    <label for="borrow_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam</label>
                    <input type="date" name="borrow_date" id="borrow_date" required
                           value="{{ old('borrow_date', date('Y-m-d')) }}"
                           min="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                    <x-input-error :messages="$errors->get('borrow_date')" class="mt-1" />
                </div>

                {{-- Tanggal Kembali --}}
                <div>
                    <label for="return_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali</label>
                    <input type="date" name="return_date" id="return_date" required
                           value="{{ old('return_date', date('Y-m-d', strtotime('+1 day'))) }}"
                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                    <x-input-error :messages="$errors->get('return_date')" class="mt-1" />
                </div>

                {{-- Keperluan --}}
                <div class="sm:col-span-2">
                    <label for="purpose" class="block text-sm font-medium text-gray-700 mb-1">Keperluan Peminjaman</label>
                    <textarea name="purpose" id="purpose" rows="4" required
                              placeholder="Contoh: Untuk keperluan praktikum mata kuliah Sistem Digital..."
                              class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">{{ old('purpose') }}</textarea>
                    <x-input-error :messages="$errors->get('purpose')" class="mt-1" />
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('katalog') }}"
                   class="px-6 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-800 transition-all">
                    Batal
                </a>
                <button type="submit"
                        class="px-8 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 active:scale-95 shadow-md shadow-blue-500/20 transition-all">
                    Kirim Permintaan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
