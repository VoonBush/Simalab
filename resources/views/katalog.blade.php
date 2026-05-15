@extends('layouts.app')
@section('title', 'Katalog Barang')
@section('page-title', 'Katalog Peralatan Lab')
@section('page-subtitle', 'Lab Teknik Digital · Universitas Lampung')

@section('content')
<div x-data="katalogPage()" class="space-y-6">

    {{-- Search & Filter Bar --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
        <form method="GET" action="{{ route('katalog') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama atau kode barang..."
                       class="w-full pl-9 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl
                              focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400 transition-all">
            </div>

            <select name="condition"
                    class="px-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-white
                           focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400">
                <option value="">Semua Kondisi</option>
                <option value="baik" {{ request('condition') === 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="rusak" {{ request('condition') === 'rusak' ? 'selected' : '' }}>Rusak</option>
                <option value="perbaikan" {{ request('condition') === 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
            </select>

            <select name="location_id"
                    class="px-4 py-2.5 text-sm border border-gray-200 rounded-xl bg-white
                           focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-400">
                <option value="">Semua Lokasi</option>
                @foreach($locations as $loc)
                <option value="{{ $loc->id }}" {{ request('location_id') == $loc->id ? 'selected' : '' }}>
                    {{ $loc->full_name }}
                </option>
                @endforeach
            </select>

            <button type="submit"
                    class="px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl
                           hover:bg-blue-700 active:scale-95 transition-all">
                Filter
            </button>
            @if(request()->hasAny(['search', 'condition', 'location_id']))
            <a href="{{ route('katalog') }}"
               class="px-4 py-2.5 bg-gray-100 text-gray-600 text-sm font-medium rounded-xl hover:bg-gray-200 transition-all">
                Reset
            </a>
            @endif
        </form>
    </div>

    {{-- Results Count --}}
    <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500">
            Menampilkan <span class="font-semibold text-gray-800">{{ $items->count() }}</span>
            dari {{ $items->total() }} barang
        </p>
    </div>

    {{-- Item Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @forelse($items as $item)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden
                    hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">

            {{-- Image --}}
            <div class="relative aspect-video bg-gray-100 overflow-hidden">
                <img src="{{ $item->image_url }}" alt="{{ $item->name }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                     onerror="this.src='https://placehold.co/400x225/f1f5f9/94a3b8?text={{ urlencode($item->name) }}'">

                {{-- Condition Badge --}}
                <div class="absolute top-2 right-2">
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold
                        {{ match($item->condition) {
                            'baik'      => 'bg-green-100 text-green-700 border border-green-200',
                            'rusak'     => 'bg-red-100 text-red-700 border border-red-200',
                            'perbaikan' => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
                            default     => 'bg-gray-100 text-gray-600',
                        } }}">
                        {{ match($item->condition) {
                            'baik'      => 'Baik',
                            'rusak'     => 'Rusak',
                            'perbaikan' => 'Perbaikan',
                            default     => $item->condition,
                        } }}
                    </span>
                </div>

                {{-- Unavailable Overlay --}}
                @if(!$item->is_available)
                <div class="absolute inset-0 bg-gray-900/50 flex items-center justify-center">
                    <span class="bg-white/90 text-gray-800 text-sm font-bold px-4 py-2 rounded-full">
                        Stok Habis
                    </span>
                </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="p-4">
                <div class="flex items-start justify-between gap-2 mb-2">
                    <h3 class="font-semibold text-gray-900 text-sm leading-snug line-clamp-2">{{ $item->name }}</h3>
                    <span class="font-mono text-xs text-gray-400 flex-shrink-0">{{ $item->code }}</span>
                </div>

                {{-- Stock --}}
                <div class="flex items-center gap-1 mb-2">
                    <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        @php $pct = $item->total_stock > 0 ? ($item->available_stock / $item->total_stock * 100) : 0; @endphp
                        <div class="h-full rounded-full {{ $pct > 50 ? 'bg-green-400' : ($pct > 0 ? 'bg-yellow-400' : 'bg-red-400') }}"
                             style="width: {{ $pct }}%"></div>
                    </div>
                    <span class="text-xs text-gray-500 flex-shrink-0">
                        {{ $item->available_stock }}/{{ $item->total_stock }}
                    </span>
                </div>

                {{-- Location --}}
                @if($item->location)
                <p class="text-xs text-gray-400 flex items-center gap-1 mb-3">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $item->location->full_name }}
                </p>
                @else
                <div class="mb-3"></div>
                @endif

                {{-- Actions --}}
                <div class="flex gap-2">
                    {{-- QR Code --}}
                    @if($item->qr_code)
                    <a href="{{ asset('storage/' . $item->qr_code) }}" target="_blank"
                       title="Lihat QR Code"
                       class="flex items-center justify-center w-9 h-9 bg-gray-100 text-gray-600
                              rounded-lg hover:bg-gray-200 transition-colors flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                    </a>
                    @endif

                    {{-- Borrow Button --}}
                    @if($item->is_available)
                    <a href="{{ route('borrowings.create', ['item_id' => $item->id]) }}"
                       class="flex-1 flex items-center justify-center gap-1.5 py-2 px-3
                              bg-blue-600 text-white text-sm font-semibold rounded-lg
                              hover:bg-blue-700 active:scale-95 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4"/>
                        </svg>
                        Pinjam
                    </a>
                    @else
                    <button disabled
                            class="flex-1 py-2 px-3 bg-gray-100 text-gray-400 text-sm font-semibold
                                   rounded-lg cursor-not-allowed">
                        Tidak Tersedia
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center text-gray-400">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <p class="text-lg font-medium">Tidak ada barang ditemukan</p>
            <p class="text-sm mt-1">Coba ubah filter pencarian Anda</p>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $items->links() }}
    </div>

</div>

<script>
function katalogPage() {
    return {};
}
</script>
@endsection
