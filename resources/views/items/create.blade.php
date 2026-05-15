@extends('layouts.app')

@section('title', 'Tambah Barang')
@section('page-title', 'Tambah Barang Baru')
@section('page-subtitle', 'Daftarkan peralatan laboratorium baru ke sistem.')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Barang --}}
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                           placeholder="Contoh: Oscilloscope Digital 50MHz"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                {{-- Kode Barang --}}
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Kode Unik</label>
                    <input type="text" name="code" id="code" required value="{{ old('code') }}"
                           placeholder="Contoh: ITM-EL-001"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                    <x-input-error :messages="$errors->get('code')" class="mt-1" />
                </div>

                {{-- Lokasi --}}
                <div>
                    <label for="location_id" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Penyimpanan</label>
                    <select name="location_id" id="location_id"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all bg-white text-gray-900">
                        <option value="">Pilih Lokasi</option>
                        @foreach($locations as $loc)
                            <option value="{{ $loc->id }}" {{ old('location_id') == $loc->id ? 'selected' : '' }}>
                                {{ $loc->full_name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('location_id')" class="mt-1" />
                </div>

                {{-- Stok Total --}}
                <div>
                    <label for="total_stock" class="block text-sm font-medium text-gray-700 mb-1">Stok Total</label>
                    <input type="number" name="total_stock" id="total_stock" required min="1" value="{{ old('total_stock', 1) }}"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                    <x-input-error :messages="$errors->get('total_stock')" class="mt-1" />
                </div>

                {{-- Stok Tersedia --}}
                <div>
                    <label for="available_stock" class="block text-sm font-medium text-gray-700 mb-1">Stok Tersedia</label>
                    <input type="number" name="available_stock" id="available_stock" required min="0" value="{{ old('available_stock', 1) }}"
                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                    <x-input-error :messages="$errors->get('available_stock')" class="mt-1" />
                </div>

                {{-- Kondisi --}}
                <div>
                    <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Kondisi</label>
                    <select name="condition" id="condition" required
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all bg-white text-gray-900">
                        <option value="baik" {{ old('condition') == 'baik' ? 'selected' : '' }}>Baik</option>
                        <option value="rusak" {{ old('condition') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="perbaikan" {{ old('condition') == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                    </select>
                    <x-input-error :messages="$errors->get('condition')" class="mt-1" />
                </div>

                {{-- Gambar --}}
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Gambar Barang</label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                    <x-input-error :messages="$errors->get('image')" class="mt-1" />
                </div>

                {{-- Deskripsi --}}
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi / Spesifikasi</label>
                    <textarea name="description" id="description" rows="4"
                              placeholder="Masukkan spesifikasi detail barang..."
                              class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.items.index') }}"
                   class="px-6 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-800 transition-all">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 active:scale-95 transition-all">
                    Simpan Barang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
