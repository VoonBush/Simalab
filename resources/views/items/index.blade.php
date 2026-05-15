@extends('layouts.app')

@section('title', 'Manajemen Barang')
@section('page-title', 'Manajemen Peralatan Lab')
@section('page-subtitle', 'Kelola inventaris barang dan stok laboratorium.')

@section('content')
<div class="space-y-6">
    {{-- Header Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex-1 max-w-md">
            <form action="{{ route('admin.items.index') }}" method="GET" class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama atau kode barang..."
                       class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
            </form>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.items.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 active:scale-95 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Barang
            </a>
        </div>
    </div>

    {{-- Items Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-100">
                        <th class="px-6 py-4 font-semibold text-gray-700">Barang</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Kode</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Lokasi</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Stok (Tersedia/Total)</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Kondisi</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($items as $item)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $item->image_url }}" alt="" class="w-10 h-10 rounded-lg object-cover bg-gray-100"
                                     onerror="this.src='https://placehold.co/100x100/f1f5f9/94a3b8?text=IMG'">
                                <div class="font-medium text-gray-900">{{ $item->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs text-gray-500">{{ $item->code }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $item->location?->full_name ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 h-1.5 w-16 bg-gray-100 rounded-full overflow-hidden">
                                    @php $pct = $item->total_stock > 0 ? ($item->available_stock / $item->total_stock * 100) : 0; @endphp
                                    <div class="h-full rounded-full {{ $pct > 50 ? 'bg-green-400' : ($pct > 0 ? 'bg-yellow-400' : 'bg-red-400') }}"
                                         style="width: {{ $pct }}%"></div>
                                </div>
                                <span class="text-xs font-medium {{ $item->available_stock == 0 ? 'text-red-600' : 'text-gray-700' }}">
                                    {{ $item->available_stock }}/{{ $item->total_stock }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php $badge = $item->condition_badge; @endphp
                            <span class="badge {{ $badge['class'] }}">
                                {{ $badge['label'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.items.show', $item) }}" class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.items.edit', $item) }}" class="p-2 text-gray-400 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-all" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.items.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus barang ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                            Belum ada barang yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($items->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $items->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
