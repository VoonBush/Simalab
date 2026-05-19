@extends('layouts.app')

@section('title', 'Peminjaman')
@section('page-title', auth()->user()->hasRole('mahasiswa') ? 'Riwayat Peminjaman Saya' : 'Daftar Peminjaman Lab')
@section('page-subtitle', 'Kelola status dan alur pengembalian barang.')

@section('content')
<div class="space-y-6">
    {{-- Stats (Optional for Staff) --}}
    @unless(auth()->user()->hasRole('mahasiswa'))
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Menunggu Approval</p>
            <p class="text-2xl font-bold text-yellow-600">{{ \App\Models\Borrowing::where('status', 'pending')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Sedang Dipinjam</p>
            <p class="text-2xl font-bold text-blue-600">{{ \App\Models\Borrowing::where('status', 'borrowed')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Terlambat</p>
            <p class="text-2xl font-bold text-red-600">{{ \App\Models\Borrowing::where('status', 'late')->count() }}</p>
        </div>
    </div>
    @endunless

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 font-semibold text-gray-700">Kode</th>
                        @unless(auth()->user()->hasRole('mahasiswa'))
                        <th class="px-6 py-4 font-semibold text-gray-700">Peminjam</th>
                        @endunless
                        <th class="px-6 py-4 font-semibold text-gray-700">Barang</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Tgl Pinjam</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Batas Kembali</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($borrowings as $b)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-mono text-xs font-bold text-blue-600">
                            {{ $b->borrow_code }}
                        </td>
                        @unless(auth()->user()->hasRole('mahasiswa'))
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $b->user->name }}</div>
                            <div class="text-[10px] text-gray-400">{{ $b->user->npm ?? '-' }}</div>
                        </td>
                        @endunless
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">
                                @if($b->details->count() > 0)
                                    {{ $b->details->first()->item->name }}
                                    @if($b->details->count() > 1)
                                        <span class="text-xs text-blue-500 font-semibold">+ {{ $b->details->count() - 1 }} Barang Lain</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </div>
                            <div class="text-[10px] text-gray-400">Total: {{ $b->details->sum('quantity') }} unit</div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $b->borrow_date->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $b->return_date->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @php $badge = $b->status_badge; @endphp
                            <span class="badge {{ $badge['class'] }}">
                                {{ $badge['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('borrowings.show', $b) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 text-xs font-bold rounded-lg hover:bg-blue-100 transition-all">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                            Tidak ada data peminjaman.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($borrowings->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $borrowings->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
