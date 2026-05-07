@extends('layouts.user')
@section('title', 'Riwayat Peminjaman — InventarisLab')
@section('page-title', 'Riwayat Peminjaman')
@section('page-subtitle', 'Daftar semua peminjaman Anda')

@section('content')
{{-- Filter Status --}}
<div class="bg-white rounded-2xl border border-slate-200 p-4 mb-6 overflow-x-auto">
    <div class="flex gap-2 min-w-max">
        <a href="{{ route('user.riwayat') }}" 
            class="px-4 py-2 rounded-lg font-medium text-sm whitespace-nowrap transition-all
            {{ $status == 'semua' ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
            Semua
        </a>
        @foreach($statusList as $stat)
            <a href="{{ route('user.riwayat', ['status' => $stat]) }}" 
                class="px-4 py-2 rounded-lg font-medium text-sm whitespace-nowrap transition-all
                {{ $status == $stat ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                {{ ucfirst($stat) }}
            </a>
        @endforeach
    </div>
</div>

{{-- Peminjaman List --}}
<div class="space-y-3">
    @forelse($peminjamans as $peminjaman)
        <div class="bg-white rounded-2xl border border-slate-200 p-5 hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h3 class="font-semibold text-slate-900">
                            @php
                                $barangNames = $peminjaman->details->map(fn($detail) => $detail->barang->nama_barang)->join(', ');
                            @endphp
                            {{ $barangNames }}
                        </h3>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-semibold
                            @if($peminjaman->status == 'diajukan') bg-yellow-100 text-yellow-800
                            @elseif($peminjaman->status == 'disetujui') bg-blue-100 text-blue-800
                            @elseif($peminjaman->status == 'dikembalikan') bg-gray-100 text-gray-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($peminjaman->status) }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500">
                        Pengajuan: {{ $peminjaman->created_at->format('d M Y H:i') }}
                    </p>
                </div>
                @if($peminjaman->details->count() > 1)
                    <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-medium">
                        {{ $peminjaman->details->count() }} item
                    </span>
                @endif
            </div>

            {{-- Details --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-3 p-3 bg-slate-50 rounded-xl">
                <div>
                    <p class="text-xs text-slate-500 mb-1">Tanggal Pinjam</p>
                    <p class="text-sm font-semibold text-slate-900">{{ $peminjaman->tanggal_pinjam->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">Target Kembali</p>
                    <p class="text-sm font-semibold text-slate-900">
                        @if($peminjaman->tanggal_kembali)
                            {{ $peminjaman->tanggal_kembali->format('d M Y') }}
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">Jumlah Item</p>
                    <p class="text-sm font-semibold text-slate-900">{{ $peminjaman->details->sum('jumlah') }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">Total Hari</p>
                    <p class="text-sm font-semibold text-slate-900">
                        @if($peminjaman->tanggal_kembali)
                            {{ $peminjaman->tanggal_kembali->diffInDays($peminjaman->tanggal_pinjam) }} hari
                        @else
                            <span class="text-slate-400">-</span>
                        @endif
                    </p>
                </div>
            </div>

            {{-- Items --}}
            <div class="space-y-2 mb-3">
                @foreach($peminjaman->details as $detail)
                    <div class="flex items-center justify-between text-sm p-2 bg-slate-50 rounded-lg">
                        <div>
                            <p class="font-medium text-slate-900">{{ $detail->barang->nama_barang }}</p>
                            <p class="text-xs text-slate-500">{{ $detail->barang->kode_barang }}</p>
                        </div>
                        <span class="font-semibold text-slate-900">{{ $detail->jumlah }}x</span>
                    </div>
                @endforeach
            </div>

            {{-- Action --}}
            @if($peminjaman->status == 'diajukan')
                <div class="flex gap-2 pt-2 border-t border-slate-200">
                    <form action="#" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full px-3 py-2 text-sm font-semibold text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors">
                            Batalkan
                        </button>
                    </form>
                </div>
            @endif
        </div>
    @empty
        <div class="text-center py-12 bg-white rounded-2xl border border-slate-200">
            <svg class="w-16 h-16 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-slate-500 font-medium mb-2">Belum ada riwayat peminjaman</p>
            <a href="{{ route('user.pinjam') }}" class="inline-block mt-4 text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-xl transition-colors">
                + Ajukan Peminjaman
            </a>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($peminjamans->hasPages())
    <div class="mt-6 flex justify-center">
        {{ $peminjamans->links() }}
    </div>
@endif
@endsection
