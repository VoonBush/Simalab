@extends('layouts.app')

@section('title', $item->name)
@section('page-title', 'Detail Barang')
@section('page-subtitle', 'Informasi lengkap spesifikasi dan status barang.')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-3">
            {{-- Image Section --}}
            <div class="p-6 bg-gray-50 flex items-center justify-center">
                <div class="relative group">
                    <img src="{{ $item->image_url }}" alt="{{ $item->name }}"
                         class="w-full max-w-[250px] aspect-square object-cover rounded-2xl shadow-md border-4 border-white"
                         onerror="this.src='https://placehold.co/400x400/f1f5f9/94a3b8?text={{ urlencode($item->name) }}'">

                    {{-- QR Code Overlay (Hidden by default, shown on hover/mobile) --}}
                    @if($item->qr_code)
                    <div class="absolute inset-0 bg-white/90 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center p-4 rounded-2xl">
                        <img src="{{ asset('storage/' . $item->qr_code) }}" class="w-32 h-32" alt="QR Code">
                        <p class="mt-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Scan to view</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Info Section --}}
            <div class="md:col-span-2 p-8 space-y-6">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wider rounded border border-blue-100">
                            {{ $item->code }}
                        </span>
                        @php $badge = $item->condition_badge; @endphp
                        <span class="badge {{ $badge['class'] }}">
                            {{ $badge['label'] }}
                        </span>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 leading-tight">{{ $item->name }}</h1>
                </div>

                <div class="grid grid-cols-2 gap-6 py-6 border-y border-gray-100">
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Stok Tersedia</p>
                        <p class="text-lg font-bold text-gray-800">{{ $item->available_stock }} <span class="text-sm font-medium text-gray-400">/ {{ $item->total_stock }} Unit</span></p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Lokasi</p>
                        <p class="text-lg font-bold text-gray-800">{{ $item->location?->full_name ?? 'N/A' }}</p>
                    </div>
                </div>

                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-2">Deskripsi & Spesifikasi</p>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ $item->description ?? 'Tidak ada deskripsi tambahan.' }}
                    </p>
                </div>

                <div class="flex items-center gap-3 pt-4">
                    @if($item->is_available)
                    <a href="{{ route('borrowings.create', ['item_id' => $item->id]) }}"
                       class="flex-1 flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 active:scale-95 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Ajukan Peminjaman
                    </a>
                    @else
                    <button disabled class="flex-1 px-6 py-3 bg-gray-100 text-gray-400 text-sm font-bold rounded-xl cursor-not-allowed">
                        Stok Tidak Tersedia
                    </button>
                    @endif

                    @role('asisten_lab|pj')
                    <a href="{{ route('admin.items.edit', $item) }}"
                       class="px-6 py-3 bg-white text-gray-700 text-sm font-bold rounded-xl border border-gray-200 hover:bg-gray-50 transition-all">
                        Edit
                    </a>
                    @endrole
                </div>
            </div>
        </div>
    </div>

    {{-- RIWAYAT PEMINJAMAN (Hanya Staff) --}}
    @role('asisten_lab|pj')
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Riwayat Peminjaman</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="text-gray-400 border-b border-gray-50">
                        <th class="pb-3 font-semibold">Peminjam</th>
                        <th class="pb-3 font-semibold">Tanggal Pinjam</th>
                        <th class="pb-3 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($item->borrowings()->latest()->take(5)->get() as $b)
                    <tr>
                        <td class="py-3">
                            <div class="flex items-center gap-2">
                                <span class="font-medium text-gray-800">{{ $b->user->name }}</span>
                            </div>
                        </td>
                        <td class="py-3 text-gray-600">{{ $b->borrow_date->format('d M Y') }}</td>
                        <td class="py-3">
                            @php $s_badge = $b->status_badge; @endphp
                            <span class="badge {{ $s_badge['class'] }}">
                                {{ $s_badge['label'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-6 text-center text-gray-400">Belum ada riwayat peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endrole
</div>
@endsection
