@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name)

@section('content')
<div class="space-y-6">

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_items'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Total Barang</p>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['available_items'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Barang Tersedia</p>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-yellow-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_borrowings'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Pending Approval</p>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['active_borrowings'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Sedang Dipinjam</p>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Total User</p>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-teal-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_modules'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Modul Aktif</p>
        </div>

    </div>

    {{-- Bottom Grid: Notifications + Recent Borrowings --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Notifikasi Pending (Livewire) --}}
        <div class="xl:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
                Permintaan Pending
            </h3>
            @livewire('assistant-notifications', ['embedded' => true])
        </div>

        {{-- Tabel Peminjaman Terbaru --}}
        <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800">Peminjaman Terbaru</h3>
                <a href="{{ route('borrowings.index') }}"
                   class="text-sm text-blue-600 hover:text-blue-700 font-medium">Lihat Semua →</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left">
                            <th class="pb-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Kode</th>
                            <th class="pb-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Peminjam</th>
                            <th class="pb-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Barang</th>
                            <th class="pb-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="pb-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($recentBorrowings as $b)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-3 font-mono text-xs text-gray-600">{{ $b->borrow_code }}</td>
                            <td class="py-3">
                                <div class="flex items-center gap-2">
                                    <img src="{{ $b->user->avatar_url }}" class="w-6 h-6 rounded-full" alt="">
                                    <span class="text-gray-800 font-medium truncate max-w-[120px]">{{ $b->user->name }}</span>
                                </div>
                            </td>
                            <td class="py-3 text-gray-600 truncate max-w-[120px]">
                                @if($b->details->count() > 0)
                                    {{ $b->details->first()->item->name }}
                                    @if($b->details->count() > 1)
                                        <span class="text-[10px] text-blue-500 font-semibold">+ {{ $b->details->count() - 1 }} Lainnya</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-3">
                                @php $badge = $b->status_badge; @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                    {{ match($b->status) {
                                        'pending'  => 'bg-yellow-100 text-yellow-700',
                                        'approved' => 'bg-green-100 text-green-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                        'borrowed' => 'bg-blue-100 text-blue-700',
                                        'returned' => 'bg-gray-100 text-gray-600',
                                        'late'     => 'bg-red-100 text-red-700',
                                        default    => 'bg-gray-100 text-gray-600',
                                    } }}">
                                    {{ $badge['label'] }}
                                </span>
                            </td>
                            <td class="py-3">
                                <a href="{{ route('borrowings.show', $b) }}"
                                   class="text-blue-600 hover:text-blue-700 text-xs font-medium">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-400 text-sm">Belum ada data peminjaman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
