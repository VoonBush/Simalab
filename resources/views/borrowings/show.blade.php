@extends('layouts.app')

@section('title', 'Detail Peminjaman ' . $borrowing->borrow_code)
@section('page-title', 'Detail Peminjaman')
@section('page-subtitle', 'Informasi status dan rincian permohonan peminjaman.')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    {{-- Main Info --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $borrowing->borrow_code }}</h1>
                        @php $badge = $borrowing->status_badge; @endphp
                        <span class="badge {{ $badge['class'] }} text-[10px] py-1 px-3">
                            {{ $badge['label'] }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-400 font-medium">Diajukan pada {{ $borrowing->created_at->format('d M Y, H:i') }}</p>
                </div>

                {{-- Aksi Cepat untuk Staff --}}
                @role('asisten_lab|pj')
                <div class="flex items-center gap-2">
                    @if($borrowing->status === 'pending')
                    <form action="{{ route('borrowings.approve', $borrowing) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white text-xs font-bold rounded-lg hover:bg-green-700 transition-all">
                            Approve
                        </button>
                    </form>
                    <button @click="$dispatch('open-modal', 'reject-modal')" class="px-4 py-2 bg-red-600 text-white text-xs font-bold rounded-lg hover:bg-red-700 transition-all">
                        Tolak
                    </button>
                    @endif

                    @if(in_array($borrowing->status, ['approved', 'borrowed']))
                    <form action="{{ route('borrowings.returned', $borrowing) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 transition-all">
                            Sudah Dikembalikan
                        </button>
                    </form>
                    @endif
                </div>
                @endrole
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Data Peminjam & Barang --}}
                <div class="space-y-6">
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Informasi Peminjam</h3>
                        <div class="flex items-center gap-3">
                            <img src="{{ $borrowing->user->avatar_url }}" class="w-12 h-12 rounded-full border border-gray-100" alt="">
                            <div>
                                <p class="text-base font-bold text-gray-800">{{ $borrowing->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $borrowing->user->npm ?? '-' }} · {{ $borrowing->user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Barang yang Dipinjam</h3>
                        <div class="space-y-3">
                            @foreach($borrowing->details as $detail)
                            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                <img src="{{ $detail->item->image_url }}" class="w-12 h-12 rounded-xl object-cover" alt="">
                                <div>
                                    <p class="text-sm font-bold text-gray-800">{{ $detail->item->name }}</p>
                                    <p class="text-xs text-gray-500">Jumlah: <span class="font-bold text-blue-600">{{ $detail->quantity }} unit</span></p>
                                    <p class="text-[10px] text-gray-400">Lokasi: {{ $detail->item->location?->full_name ?? '-' }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Waktu & Keperluan --}}
                <div class="space-y-6">
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Jadwal Peminjaman</h3>
                        <div class="flex items-center gap-8">
                            <div>
                                <p class="text-xs text-gray-400 font-medium mb-0.5">Tanggal Pinjam</p>
                                <p class="text-sm font-bold text-gray-800">{{ $borrowing->borrow_date->format('d M Y') }}</p>
                            </div>
                            <div class="h-8 w-px bg-gray-100"></div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium mb-0.5">Batas Kembali</p>
                                <p class="text-sm font-bold text-gray-800">{{ $borrowing->return_date->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Keperluan</h3>
                        <p class="text-sm text-gray-600 leading-relaxed bg-gray-50 p-4 rounded-xl border border-gray-100 italic">
                            "{{ $borrowing->purpose }}"
                        </p>
                    </div>

                    @if($borrowing->rejection_reason)
                    <div>
                        <h3 class="text-xs font-bold text-red-400 uppercase tracking-widest mb-2">Alasan Penolakan</h3>
                        <p class="text-sm text-red-600 bg-red-50 p-4 rounded-xl border border-red-100">
                            {{ $borrowing->rejection_reason }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Riwayat Status/Log (Optional) --}}
    @if($borrowing->approved_by)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-xs text-gray-500">
                {{ $borrowing->status === 'rejected' ? 'Ditolak oleh' : 'Disetujui oleh' }}
                <span class="font-bold text-gray-800">{{ $borrowing->approver->name }}</span>
                pada {{ $borrowing->approved_at?->format('d M Y, H:i') }}
            </p>
        </div>
    </div>
    @endif
</div>

{{-- Reject Modal Placeholder (Require simple Alpine.js logic in layouts if needed) --}}
<div x-data="{ open: false }" @open-modal.window="if($event.detail === 'reject-modal') open = true" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black/50 transition-opacity" @click="open = false"></div>
        <div class="relative bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Tolak Peminjaman</h3>
            <form action="{{ route('borrowings.reject', $borrowing) }}" method="POST">
                @csrf @method('PATCH')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Penolakan</label>
                    <textarea name="rejection_reason" required rows="3" class="w-full px-4 py-2 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-red-500/20 focus:border-red-400"></textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="open = false" class="px-4 py-2 text-sm font-medium text-gray-500">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-bold rounded-lg hover:bg-red-700 transition-all">Kirim Penolakan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
