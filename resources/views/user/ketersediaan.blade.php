@extends('layouts.user')
@section('title', 'Ketersediaan Barang — InventarisLab')
@section('page-title', 'Ketersediaan Barang')
@section('page-subtitle', 'Peralatan laboratorium yang tersedia untuk dipinjam')

@section('content')
{{-- Filter Kategori --}}
<div class="bg-white rounded-2xl border border-slate-200 p-4 mb-6 overflow-x-auto">
    <div class="flex gap-2 min-w-max">
        <a href="{{ route('user.ketersediaan') }}" 
            class="px-4 py-2 rounded-lg font-medium text-sm whitespace-nowrap transition-all
            {{ $kategori == 'semua' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
            Semua
        </a>
        @foreach($kategoriList as $cat)
            <a href="{{ route('user.ketersediaan', ['kategori' => $cat]) }}" 
                class="px-4 py-2 rounded-lg font-medium text-sm whitespace-nowrap transition-all
                {{ $kategori == $cat ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                {{ ucfirst($cat) }}
            </a>
        @endforeach
    </div>
</div>

{{-- Barang Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-6">
    @forelse($barangs as $barang)
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg transition-all group">
            <div class="h-24 bg-gradient-to-br from-green-100 to-green-50 flex items-center justify-center relative">
                <div class="absolute top-2 right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-lg">
                    Tersedia: {{ $barang->stok_tersedia }}
                </div>
                <svg class="w-12 h-12 text-green-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
            </div>
            
            <div class="p-3">
                <h3 class="font-semibold text-slate-900 mb-1 text-sm line-clamp-2">{{ $barang->nama_barang }}</h3>
                <p class="text-xs text-slate-500 mb-2">{{ $barang->kode_barang }}</p>
                
                <div class="mb-3 text-xs text-slate-600">
                    <div class="flex justify-between mb-1">
                        <span>Ketersediaan</span>
                        <span class="font-semibold">{{ $barang->stok_tersedia }}/{{ $barang->total_stok }}</span>
                    </div>
                    <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                        <div class="h-full bg-green-500 rounded-full" style="width: {{ ($barang->stok_tersedia / $barang->total_stok * 100) }}%"></div>
                    </div>
                </div>

                <a href="{{ route('user.pinjam', ['barang_id' => $barang->id_barang]) }}" 
                    class="w-full text-center text-xs font-bold text-white bg-green-600 hover:bg-green-700 py-2 rounded-lg transition-colors">
                    Pinjam
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full">
            <div class="text-center py-12 bg-white rounded-2xl border border-slate-200">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/>
                </svg>
                <p class="text-slate-500 font-medium">Tidak ada barang tersedia</p>
                <p class="text-slate-400 text-sm">Silakan cek kategori lain atau kembali kemudian</p>
            </div>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
<div class="flex justify-center">
    {{ $barangs->links() }}
</div>
@endsection
