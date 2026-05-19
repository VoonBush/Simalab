@extends('layouts.app')

@section('title', 'Modul Praktikum')
@section('page-title', 'Panduan Praktikum')
@section('page-subtitle', 'Akses modul dan referensi belajar Lab Teknik Digital.')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <h2 class="text-xl font-bold text-gray-800 ">Daftar Modul Praktikum</h2>

        @role('asisten_lab|pj')
        <a href="{{ route('modules.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 active:scale-95 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Unggah Modul
        </a>
        @endrole
    </div>

    {{-- Module Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($modules as $m)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all group">
            {{-- Cover --}}
            <div class="aspect-[3/4] bg-gray-100 relative overflow-hidden">
                <img src="{{ $m->cover_url }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                     onerror="this.src='https://placehold.co/300x400/3b82f6/ffffff?text={{ urlencode($m->title) }}'">

                {{-- Overlay Download Button --}}
                @if($m->file_path)
                <div class="absolute inset-0 bg-gray-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                    <a href="{{ asset('storage/' . $m->file_path) }}" target="_blank"
                       class="px-6 py-2 bg-white text-blue-600 text-sm font-bold rounded-full shadow-lg hover:bg-blue-50 transition-colors">
                        Buka PDF
                    </a>
                </div>
                @endif
            </div>

            <div class="p-5">
                <h3 class="font-bold text-gray-900 leading-tight mb-2 line-clamp-2">{{ $m->title }}</h3>
                <p class="text-xs text-gray-400 mb-4 line-clamp-2">{{ $m->description ?? 'Tidak ada deskripsi.' }}</p>

                <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-[10px] font-bold text-blue-600">
                            {{ strtoupper(substr($m->author->name, 0, 1)) }}
                        </div>
                        <span class="text-[10px] text-gray-400 font-medium truncate max-w-[80px]">{{ $m->author->name }}</span>
                    </div>

                    @role('asisten_lab|pj')
                    <form action="{{ route('modules.destroy', $m) }}" method="POST" onsubmit="return confirm('Hapus modul ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                    @endrole
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center text-gray-400">
            <p class="text-lg font-medium">Belum ada modul praktikum.</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $modules->links() }}
    </div>
</div>
@endsection
