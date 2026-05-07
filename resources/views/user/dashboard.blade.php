@extends('layouts.user')
@section('title', 'Beranda — InventarisLab')
@section('page-title', 'Beranda')
@section('page-subtitle', 'Selamat datang kembali!')

@section('content')
{{-- Greeting Banner --}}
<div class="relative bg-gradient-to-br from-blue-800 via-blue-700 to-blue-500 rounded-3xl p-7 mb-6 text-white overflow-hidden">
    <div class="absolute top-0 right-0 w-40 h-40 bg-white/5 rounded-full -mr-20 -mt-20"></div>
    <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full -ml-16 -mb-16"></div>
    
    <div class="relative z-10">
        <h1 class="text-3xl font-bold mb-2">Selamat datang, {{ auth()->user()->nama }}! 👋</h1>
        <p class="text-blue-100">Kelola peminjaman barang laboratorium Anda dengan mudah</p>
    </div>
</div>

{{-- Quick Stats --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-slate-500">Total Peminjaman</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalPinjam }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-slate-500">Sedang Diproses</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalProses }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-slate-500">Status Akun</p>
            <p class="text-2xl font-bold text-green-600">Aktif</p>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <a href="{{ route('user.barang') }}" class="bg-white rounded-2xl border border-slate-200 p-5 hover:shadow-lg hover:border-blue-300 transition-all group">
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
            </div>
            <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
        <h3 class="font-semibold text-slate-900 mb-1">Daftar Barang</h3>
        <p class="text-sm text-slate-500">Lihat semua barang yang tersedia untuk dipinjam</p>
    </a>

    <a href="{{ route('user.pinjam') }}" class="bg-white rounded-2xl border border-slate-200 p-5 hover:shadow-lg hover:border-green-300 transition-all group">
        <div class="flex items-start justify-between mb-3">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <svg class="w-5 h-5 text-slate-400 group-hover:text-green-500 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
        <h3 class="font-semibold text-slate-900 mb-1">Pinjam Barang</h3>
        <p class="text-sm text-slate-500">Ajukan permintaan peminjaman barang baru</p>
    </a>
</div>

{{-- Peminjaman Terbaru --}}
<div class="bg-white rounded-2xl border border-slate-200 p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-slate-900">Peminjaman Terbaru</h2>
        <a href="{{ route('user.riwayat') }}" class="text-xs text-blue-600 hover:text-blue-700 font-medium bg-blue-50 px-3 py-1.5 rounded-xl">Lihat semua →</a>
    </div>

    @if($peminjamans->count() > 0)
        <div class="space-y-3">
            @foreach($peminjamans as $peminjaman)
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl hover:bg-slate-100 transition-colors">
                    <div class="flex-1">
                        <p class="font-medium text-slate-900">
                            @foreach($peminjaman->details as $detail)
                                <span>{{ $detail->barang->nama_barang }}</span>
                                @if(!$loop->last), @endif
                            @endforeach
                        </p>
                        <p class="text-xs text-slate-500">{{ $peminjaman->created_at->format('d M Y') }}</p>
                    </div>
                    <span class="px-3 py-1 rounded-lg text-xs font-semibold
                        @if($peminjaman->status_peminjaman == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($peminjaman->status_peminjaman == 'disetujui') bg-blue-100 text-blue-800
                        @elseif($peminjaman->status_peminjaman == 'dipinjam') bg-green-100 text-green-800
                        @elseif($peminjaman->status_peminjaman == 'dikembalikan') bg-gray-100 text-gray-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($peminjaman->status_peminjaman) }}
                    </span>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <svg class="w-12 h-12 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
            <p class="text-slate-500 text-sm">Belum ada peminjaman</p>
            <a href="{{ route('user.pinjam') }}" class="inline-block mt-4 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-xl transition-colors">+ Ajukan Pinjaman</a>
        </div>
    @endif
</div>
@endsection
