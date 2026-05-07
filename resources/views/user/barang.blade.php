@extends('layouts.user')
@section('title', 'Daftar Barang — InventarisLab')
@section('page-title', 'Daftar Barang')
@section('page-subtitle', 'Semua peralatan laboratorium yang tersedia')

@section('content')
{{-- Header + Search --}}
<div class="bg-white rounded-2xl border border-slate-200 p-5 mb-6">
    <form method="GET" action="{{ route('user.barang') }}" class="flex flex-col sm:flex-row gap-3">
        <div class="flex-1 relative">
            <svg class="absolute left-3 top-3 w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" placeholder="Cari barang..." value="{{ request('search') }}" 
                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
        </div>
        <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors font-medium">
            Cari
        </button>
    </form>
</div>

{{-- Barang Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    @forelse($barangs as $barang)
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg transition-shadow group">
            <div class="h-32 bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center">
                <svg class="w-16 h-16 text-blue-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
            </div>
            
            <div class="p-4">
                <h3 class="font-semibold text-slate-900 mb-1 line-clamp-2">{{ $barang->nama_barang }}</h3>
                <p class="text-xs text-slate-500 mb-3">Kode: {{ $barang->kode_barang }}</p>
                
                <div class="space-y-2 mb-4">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-600">Stok Tersedia</span>
                        <span class="font-semibold text-green-600">{{ $barang->stok_tersedia }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-600">Total Stok</span>
                        <span class="font-semibold text-slate-900">{{ $barang->total_stok }}</span>
                    </div>
                </div>

                <div class="w-full h-1 bg-slate-200 rounded-full overflow-hidden">
                    <div class="h-full bg-green-500 rounded-full" style="width: {{ ($barang->stok_tersedia / $barang->total_stok * 100) }}%"></div>
                </div>

                <a href="{{ route('user.pinjam', ['barang_id' => $barang->id_barang]) }}" 
                    class="block text-center text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 py-2.5 rounded-xl transition-colors mt-4 group-hover:shadow-md">
                    Pinjam Sekarang
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full">
            <div class="text-center py-12 bg-white rounded-2xl border border-slate-200">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
                <p class="text-slate-500 font-medium mb-2">Barang tidak ditemukan</p>
                <p class="text-slate-400 text-sm">Coba ubah kata kunci pencarian Anda</p>
            </div>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
<div class="flex justify-center">
    {{ $barangs->links() }}
</div>
@endsection
