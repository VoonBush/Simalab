@extends('layouts.app')

@section('title', 'Unggah Modul')
@section('page-title', 'Unggah Modul Baru')
@section('page-subtitle', 'Tambahkan panduan praktikum ke katalog digital.')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('modules.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Modul</label>
                <input type="text" name="title" id="title" required value="{{ old('title') }}"
                       placeholder="Contoh: Modul 1 - Dasar Elektronika Digital"
                       class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
                <x-input-error :messages="$errors->get('title')" class="mt-1" />
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                <textarea name="description" id="description" rows="3"
                          placeholder="Jelaskan isi modul ini..."
                          class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-1" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-1">File Modul (PDF)</label>
                    <input type="file" name="file" id="file" accept=".pdf,.doc,.docx" required
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                    <x-input-error :messages="$errors->get('file')" class="mt-1" />
                </div>

                <div>
                    <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-1">Cover Modul (Gambar)</label>
                    <input type="file" name="cover_image" id="cover_image" accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all">
                    <x-input-error :messages="$errors->get('cover_image')" class="mt-1" />
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}
                       class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <label for="is_published" class="text-sm text-gray-700">Terbitkan langsung ke mahasiswa</label>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('modules.index') }}"
                   class="px-6 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-800 transition-all">
                    Batal
                </a>
                <button type="submit"
                        class="px-8 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 active:scale-95 transition-all">
                    Simpan Modul
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
